<?php

use app\core\entity\Message;

include_once($params["header"] ?? "header.php");

$msg = $params["msg"] ?? Message::getMessage(Message::ACCESS_DENIED_MSG) . "<br>";

echo '<h3 style="text-align: center;">'. $msg .'</h3><br>';

include_once($params["footer"] ?? "footer.php");