<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10/20/14
 * Time: 3:33 PM
 */

namespace TPPPTX\Logger;


use Monolog\Handler\AbstractHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;

class GroupingHandler extends AbstractHandler {

    protected $buffer = [];
    protected $handler = null;

    /**
     * @var int Max level which still allows grouping. Higher level will never be grouped
     */
    protected $maxLevel = Logger::INFO;


    function __construct(HandlerInterface $handler, $maxLevel = Logger::INFO)
    {
        $this->maxLevel = $maxLevel;
        $this->handler = $handler;
        register_shutdown_function(array($this, 'close'));
    }


    /**
     * Handles a record.
     *
     * All records may be passed to this method, and the handler should discard
     * those that it does not want to handle.
     *
     * The return value of this function controls the bubbling process of the handler stack.
     * Unless the bubbling is interrupted (by returning true), the Logger class will keep on
     * calling further handlers in the stack with a given log record.
     *
     * @param  array $record The record to handle
     * @return Boolean true means that this handler handled the record, and that bubbling is not permitted.
     *                        false means the record was either not processed or that this handler allows bubbling.
     */
    public function handle(array $record)
    {
        $index = md5($record['message']);

        if ($record['level'] > $this->maxLevel) {
            $this->buffer[$index] = [
                'record' => $record,
            ];

            return true;
        }

        if (array_key_exists($index, $this->buffer)) {
            $this->buffer[$index]['count']++;
            return true;
        }

        if ($this->processors) {
            foreach ($this->processors as $processor) {
                $record = call_user_func($processor, $record);
            }
        }

        $this->buffer[$index] = [
            'record' => $record,
            'count' => 0,
        ];

        return true;
    }

    public function __destruct()
    {
        // suppress the parent behavior since we already have register_shutdown_function()
        // to call close(), and the reference contained there will prevent this from being
        // GC'd until the end of the request
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->flush();
    }

    public function flush()
    {
        $records = [];


        foreach ($this->buffer as $recordData) {
            if (array_key_exists('count', $recordData))
                $recordData['record']['message'] .= " ({$recordData['count']} time(s))";

            $records[] = $recordData['record'];
        }

        $this->handler->handleBatch($records);
    }

} 