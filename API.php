<?php
class RESTFUL                        //This class manages restful calls and provides the called method, controller, id etc..
{
    public  $method, $controller, $action, $id, $params;

    public function __construct()
    {
        header("Content-Type: application/json");
        $this->method=$_SERVER['REQUEST_METHOD'];

        if ($this->method == 'PUT') {
            $raw = '';
            $httpContent = fopen('php://input', 'r');
            while ($kb = fread($httpContent, 1024)) {
                $raw .= $kb;
            }

            fclose($httpContent);
            $params = array();
            parse_str($raw, $params);


            if (isset($params['data'])) {
                $this->params = json_decode(stripslashes($params['data']));

            } else {
                $params = json_decode(stripslashes($raw));
                $this->params = $params;
            }
        } else {

            $this->params = (isset($_REQUEST['data'])) ? json_decode(stripslashes($_REQUEST['data'])) : null;

            if (isset($_REQUEST['data'])) {
                $this->params = json_decode(stripslashes($_REQUEST['data']));
            } else {
                $raw = '';
                $httpContent = fopen('php://input', 'r');
                while ($kb = fread($httpContent, 1024)) {
                    $raw .= $kb;
                }
                $params = json_decode(stripslashes($raw));
                if ($params) {
                    $this->params = $params;
                }
            }

        }

        if (isset($_SERVER["PATH_INFO"])) {
            /*used to break up the url path into controller which provides the class to be instantiated
             action which tells any action to be called on that class
             and id which is numeric or unique
            */


            $cai = '/^\/([a-z]+\w)\/([a-z]+\w)\/([0-9]+)$/'; // /controller/action/id
            $ca = '/^\/([a-z]+\w)\/([a-z]+)$/'; // /controller/action
            $ci = '/^\/([a-z]+\w)\/([0-9]+)$/'; // /controller/id
            $c = '/^\/([a-z]+\w)$/'; // /controller
            $i = '/^\/([0-9]+)$/'; // /id
            $matches = array();
            if (preg_match($cai, $_SERVER["PATH_INFO"], $matches)) {
                $this->controller = $matches[1];
                $this->action = $matches[2];
                $this->id = $matches[3];
            } else if (preg_match($ca, $_SERVER["PATH_INFO"], $matches)) {
                $this->controller = $matches[1];
                $this->action = $matches[2];
            } else if (preg_match($ci, $_SERVER["PATH_INFO"], $matches)) {
                $this->controller = $matches[1];
                $this->id = $matches[2];
            } else if (preg_match($c, $_SERVER["PATH_INFO"], $matches)) {

                //echo '1';

                $this->controller = $matches[1];
            } else if (preg_match($i, $_SERVER["PATH_INFO"], $matches)) {
                $this->id = $matches[1];
            }
        }


    }
}