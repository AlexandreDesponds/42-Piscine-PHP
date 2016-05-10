<?php
    require_once('init.php');
    require_once('ship.php');
    require_once('control.php');

    $app->get('/', function() use ($app){
        $game = new Game();
        $app->render('home.twig', array('maps' => $game->getMap()->getMap(), 'ships' => $game->getShipArray()));
    });