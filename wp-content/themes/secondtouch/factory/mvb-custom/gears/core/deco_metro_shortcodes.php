<?php

class Deco_Metro_Shortcodes
{
    protected $mvb_instance;

    public function __construct(Metro_Shortcodes $instance) {
        $this->mvb_instance = $instance;

        $this->_add_shortcode( 'mvb_tiles', 'MVB_Tiles', $this->the_method);
        $this->_add_shortcode( 'mvb_tab', 'MVB_Tiles', 'repeater_'.$this->the_method);
		
		$this->_add_shortcode( 'mvb_call_to_action', 'MVB_Call_To_Action', $this->the_method);
		
        
    }// end __construct()

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