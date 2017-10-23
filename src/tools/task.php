<?php

namespace Tools\tools;


class task
{
   protected  $taskId;

    protected $coroutine;

    protected $sendValue = null;

    protected $brforeFirstYield = true;

    public function __construct($taskId,\Generator $coroutine)
    {
         $this->taskId = $taskId;
        $this->coroutine = $coroutine;
    }

    public function  run()
    {
        if ($this->brforeFirstYield){
            $this->brforeFirstYield = false;
            return $this->coroutine->current();
        }else{
            $value = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $value;
        }
    }

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param null $sendValue
     */
    public function setSendValue($sendValue)
    {
        $this->sendValue = $sendValue;
    }

    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}