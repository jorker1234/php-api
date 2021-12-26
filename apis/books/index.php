<?php
    require __DIR__ . "/../../inc/bootstrap.php";

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    require PROJECT_ROOT_PATH . "/Controller/Api/BookController.php";
    $controller = new BookController();

    $strMethodName = 'list';
    $controller->action();
?>