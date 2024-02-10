<?php

namespace app\router;

require_once("Request.php");

use app\request\Request;

class Router {

    static public function Route() {
        $request = new Request();
        $data = $request->GetData();

        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}