<?php
    $app->get('/init', function() use ($app){
        $map = new Map();
        $map->initMap();
    });