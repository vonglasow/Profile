<?php

namespace Profile;

class Profile
{
    private $proxifiedClass;
    protected static $benchmark;

    public function __construct($proxifiedClass)
    {
        $this->proxifiedClass = $proxifiedClass;
        $this->unique = uniqid();
    }

    public function __call($methodName, $params)
    {
        $class = get_class($this->proxifiedClass);
        if (is_callable(array($this->proxifiedClass, $methodName))) {
            $this->doSomethingBeforeCall($class, $methodName);

            $return = call_user_func(array($this->proxifiedClass, $methodName), $params);

            $this->doSomethingAfterCall($class, $methodName);
        } else {
            throw new \BadMethodCallException("No callable method $methodName at $class class");
        }

        return $return;
    }

    public function getBenchmark()
    {
        return self::$benchmark ?: self::$benchmark = Bench\Mark::run();
    }

    public function getMarkName($className, $methodName)
    {
        $this->getBenchmark();
        $markName = $className.'::'.$methodName . $this->unique;
        self::$benchmark->setGroup($className);
        self::$benchmark->setUniqid($this->unique);

        return $markName;
    }

    private function doSomethingBeforeCall($className, $methodName)
    {
        self::$benchmark->{$this->getMarkName($className, $methodName)}->start();
    }

    private function doSomethingAfterCall($className, $methodName)
    {
        self::$benchmark->{$this->getMarkName($className, $methodName)}->stop();
    }
}