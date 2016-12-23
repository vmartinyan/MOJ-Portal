<?php

class Deco_Metro_Ajax
{
    protected $mvb_instance;

    public function __construct(Metro_Ajax $instance) {
        $this->mvb_instance = $instance;
    }//end __construct()

    public function __call($method, $args) {
        return call_user_func_array(array($this->mvb_instance, $method), $args);
    }//end __call()

    public function __get($key) {
        return $this->mvb_instance->$key;
    }//end __get();

    public function __set($key, $val) {
        return $this->mvb_instance->$key = $val;
    }//end __set();

}//end class