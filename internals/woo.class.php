<?php
/*
    $about = array(
        "author" -> "Gemini <859077290@qq.com>",
        "date"   -> "2016/07/21",
        "desc"   -> "Woo -- Yet Another TINY PHP framework."
    );
*/
require_once "singleton.class.php";

class Woo extends Singleton
{
    public function serve($root_dir, $handler_dir)
    {
        defined('ROOT_DIR') or define('ROOT_DIR', $root_dir);
        defined('WOO_DIR') or define('WOO_DIR', dirname(__FILE__));
        defined('HANDLER_DIR') or define('HANDLER_DIR', $handler_dir);

        $rd = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);
        self::_dispatch($_SERVER['REQUEST_METHOD'], $rd->action, $rd->data);
    }

    private function _dispatch($method, $action, $action_data)
    {
        $action = trim($action); $method = trim($method);
        if(empty($action) or empty($method)) {
            //Result::instance()->response(ERR_INVALID_PARAM);
        }

        $handler_tag = strtolower($action);
        $handler_path = HANDLER_DIR . $handler_tag . ".class.php";
        if(file_exists($handler_path)) {
            require_once $handler_path;
            $handler_tag::instance()->do_handle($method, $action_data);
        } else {
            //Result::instance()->response(ERR_INVALID_ACTION);
        }
    }
}
?>

