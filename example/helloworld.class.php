<?php
require_once  WOO_DIR . "/base_handler.class.php";

final class helloworld extends BaseHandler 
{
    protected function do_post($req) 
    {
        // dealing your bussiness here
        $rsp = new stdClass();
        $rsp->ret   = 0;
        $rsp->msg   = 'succ.';
        $rsp->data  = "Hello world!";
        echo json_encode($rsp);
    }
}
?>

