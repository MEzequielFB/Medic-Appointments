<?php

if (isset($_GET["action"])) {
    require_once __DIR__ . "/../route.php";
} else if (isset($_GET["resource"])) {
    require_once __DIR__ . "/../apiRoute.php";
}

die();
?>