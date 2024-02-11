<?php

namespace app\router;

use app\request\Request;

class Router {

    static public function Route() {
        $request = new Request();
        $data = $request->GetData();

        $controller = "app\controller\\" . $data["controller"];
        $method = $data["method"];

        if(!file_exists(APP_DIR . "app/controller/" . $data["controller"] . ".php")) {
            $controller = "app\controller\Controller";
            $method = "_404";
        }

        if(!method_exists($controller, $method)) {
            $method = "_404";
        }
        
        (new $controller())->$method();
    }
}