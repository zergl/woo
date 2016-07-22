<?php
require_once "singleton.class.php";

abstract class BaseHandler extends Singleton
{
	public function do_handle($method, $req_data)
	{
		//supported methods
		static $METHODS = array("get" => "", "post" => "");
		
		$m = strtolower($method);
		$handle = "do_" . (array_key_exists($m, $METHODS) == true? $m : "default");
		$this->$handle($req_data);
	}

	protected function do_default(){}
	protected function do_get($req_data){}
	protected function do_post($req_data){}
}
?>

