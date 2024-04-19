<?php

namespace app\core\router;

use app\core\request\Request;

class Router {

    static public function route() {
        $request = new Request;
        $data = $request->GetData();

        $controller = "app\core\controller\\" . $data["controller"];
        $method = $data["method"];

        if(!file_exists(APP_DIR . "app/core/controller/" . $data["controller"] . ".php")) {
            $controller = "app\core\controller\Controller";
            $method = "_404";
        }

        if(!method_exists($controller, $method)) {
            $method = "_404";
        }

        (new $controller())->$method();
    }
}