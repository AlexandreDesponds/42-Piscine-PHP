<?php
    session_start();

    //require configuration
    $conf = parse_ini_file('../config/local.ini');

    //require dependencies
    require_once('../vendor/autoload.php');

    //slim configuration
    $app = new \Slim\Slim(array(
        'debug' => $conf['SLIM_DEBUG'],
        'log.enable' => $conf['SLIM_LOG'],
        'templates.path' => '../app/view',
        'view' => new \Slim\Views\Twig(),
        'cache' => dirname(__FILE__) . '/cache',
    ));

    //twig configuration
    $view = $app->view();
    $view->parserOptions = array(
        'debug' => $conf['SLIM_DEBUG'],
    );
    $view->parserExtensions = array(
        new \Slim\Views\TwigExtension(),
    );

    //require route and model
    require_once('route/route.php');
    require_once('model/model.php');

    //loginSession
    if (isset($_SESSION['people']) && !empty($_SESSION['people'])) {
        $people = unserialize($_SESSION['people']);
        $app->view->setData('people', $people);
    }

    // run
    $app->run();