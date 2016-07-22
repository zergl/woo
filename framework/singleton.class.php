<?php

abstract class Singleton
{
	private static  $_inst = array();
	private function __construct() {}
	private function __clone(){}
	public static function instance() {
		$class = get_called_class();
		if(!array_key_exists($class, self::$_inst) 
			or is_null(self::$_inst[$class])) 
		{
			self::$_inst[$class] = new static();
		}
		
		return self::$_inst[$class];
	}
}
 
?>

