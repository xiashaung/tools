<?php
namespace Tools\Coroutine;

/**
 * Class Task
 * @package Tools\Coroutine
 * 任务类
 */
class Task
{
    protected $taskId;

    protected $coroutine;

    protected $sendValue = null;

    protected $beforeFirstYield = true;

    /**
     * Task constructor.
     * @param $taskId  int 任务id
     * @param \Generator $coroutine  生成器/迭代器
     *
     */
    public function __construct($taskId,\Generator $coroutine)
    {
        $this->taskId = $taskId;

        $this->coroutine = $coroutine;//协程
    }

    /**
     * @return mixed
     * 获取当前任务id
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param null $sendValue
     * 设置一个要发送的值
     */
    public function setSendValue($sendValue)
    {
        $this->sendValue = $sendValue;
    }

    /**
     * @return mixed
     * 执行当前任务
     */
    public function run()
    {
        /**
         * 执行前一个是为了确保第一个能被正确调用
         */
        if ($this->beforeFirstYield){
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        }else{
            $retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;

            return $retval;

        }
    }

    /**
     * @return bool
     * 当前任务是否已结束
     */
    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}