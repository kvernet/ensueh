<?php

include_once($params["header"] ?? "header.php");

$msg = $params["msg"] ?? ACCESS_DENIED_MSG . "<br>";

echo '<h3 style="text-align: center;">'. $msg .'</h3><br>';

include_once($params["footer"] ?? "footer.php");