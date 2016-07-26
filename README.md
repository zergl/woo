# Woo - Yet Another TINY PHP Application Framework.

## How to Use

the struct of demo application as follows:

```
$ tree woo_demo/
woo_demo/
|-- import
|   `-- woo  //the Woo Framework; just copy and place here.
|       |-- README.md
|       |-- app.php
|       |-- internals
|       |   |-- base_handler.class.php
|       |   |-- db_handler.class.php
|       |   |-- singleton.class.php
|       |   `-- woo.class.php
|       `-- myhandlers
|           `-- helloworld.class.php
|-- index.php //the application entry
`-- myhandlers // directory for your business handlers
    `-- helloworld.class.php
```

step-by-step for a helloworld application:

* download Woo and place it into you project's struct:

* create your entry:

```
<?php
    require_once dirname(__FILE__) . '/import/woo/' . "app.php";
    
    $myhandler_dir = dirname(__FILE__) . "/myhandlers/";
    Woo::instance()->serve($myhandler_dir);
?>
```
 
* implement your handler:

source code for myhandlers/helloworld.php:

```
<?php
require_once  WOO_DIR . "/base_handler.class.php";

class helloworld extends BaseHandler 
{
    protected function do_post($req) 
    {
        // dealing your bussiness here
        $rsp->ret = 0;
        $rsp->msg = 'succ.';
        $rsp->data = "Hello world!";
        echo json_encode($rsp);
    }
}
?>

```

* testing

```
curl -H "Content-Type:application/x-www.form-urlencoded"   --data '{"action" : "helloworld","data" : {"a":1, "b":2}}' http://127.0.0.1/wooapp/index.php -v
```

Request:
```
POST /wooapp/index.php HTTP/1.1
Host: 127.0.0.1
User-Agent: curl/7.49.1
Accept: */*
Content-Type:application/x-www.form-urlencoded
Content-Length: 49
```

Response:
```
HTTP/1.1 200 OK
Date: Tue, 26 Jul 2016 13:19:54 GMT
Server: Apache/2.4.6 (CentOS) PHP/5.4.16
X-Powered-By: PHP/5.4.16
Content-Length: 51
Content-Type: text/html; charset=UTF-8


{"ret":0,"msg":"succ.","data":"Hello world!"}

```

## Feedbacks
[zergl] (e3.gemini#qq.com)

