<?php
require_once "singleton.class.php";

abstract class BaseHandler extends Singleton
{
    final public function do_handle($method, $req_data)
    {
        //supported methods
        static $METHODS = array("get", "post");
        
        $m = strtolower($method);
        $handle = "do_" . (in_array($m, $METHODS) ? $m : "default");
        $this->$handle($req_data);
    }

    protected function do_default(){ /*not implemented yet!*/ }
    protected function do_get($req_data){}
    protected function do_post($req_data){}
}
?>

