<?php

namespace app\core\request;

class Request {
    private $data;

    public function __construct() {
        $this->data = [
            "server" => $_SERVER,
            "request" => $_REQUEST,
            "post" => $_POST,
            "get" => $_GET,
            "cookie" => $_COOKIE,
            "files" => $_FILES
        ];
    }

    public function __destruct() {
        unset($this->data);
    }

    public function getData() : array {
        $d = $this->get();
        $this->data["controller"] = $d["controller"];
        $this->data["method"] = $d["method"];
        $this->data["query"] = $d["query"];
        return $this->data;
    }

    private function get() : array {
        $uri = parse_url($this->data["server"]["REQUEST_URI"]);
        $path = $uri["path"];
        $query = $uri["query"];

        $explode_path = explode('/', $path);

        $controller = $explode_path[1] == "" ? "home" : $explode_path[1];
        $controller = ucfirst($controller) . "Controller";
        $method = ($explode_path[2] == null || $explode_path[2] == "") ? "index" : $explode_path[2];

        if(count($explode_path) > 3) {
            if(strlen($explode_path[3]) != 0) {
                $method = "_404";
            }
        }
        
        return [
            "controller" => $controller,
            "method" =>$method,
            "query" => $query
        ];
    }
}