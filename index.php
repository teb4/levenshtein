<?php
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/DefaultView.php';
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/DefaultController.php';
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/ResultView.php';
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/ResultController.php';    
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/Factory.php';
    
    $controller = Factory::createController( $_REQUEST );
    $view = $controller->getView();
    print $view->toHtml();
?>