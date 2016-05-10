<?php
    $app->get('/ship/info/:id', function($id) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $tmp = $ship->toArray();
            unset ($tmp['_weapons']);
            foreach($ship->getWeapons() as $w) {
                $tmp['_weapons'][] = $w->toArray();
            }
            echo json_encode($tmp);
        } else {
            echo "error";
        }
    });

    $app->get('/ship/turn/:id/:dir', function($id, $dir) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->turn($dir);
        } else {
            echo "error";
        }
    });

    $app->get('/ship/move/:id/:case', function($id, $case) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->move($case);
        } else {
            echo "error";
        }
    });

    $app->get('/ship/html', function() use ($app){
        $game = new Game();
        $app->render('include/ships.twig', array('ships' => $game->getShipArray()));
    });

    $app->get('/ship/active/:id/:player', function($id, $player) use ($app){
        $game = new Game();
        if (!$game->possibleActivation())
            return "error";
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship && $ship->getPlayer() == $player){
            $ship->active();
        } else {
            echo "error";
        }
    });

    $app->get('/ship/stopMove/:id', function($id) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->stopMove();
        } else {
            echo "error";
        }

    });

    $app->get('/ship/ppShield/:id', function($id) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->addShield();
        } else {
            echo "error";
        }
    });

    $app->get('/ship/ppSpeed/:id', function($id) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->addSpeed();
        } else {
            echo "error";
        }
    });

    $app->get('/ship/ppStop/:id', function($id) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->ppStop();
        } else {
            echo "error";
        }
    });

    $app->get('/ship/fireStop/:id', function($id) use ($app){
        $ship = ShipFactory::load($id);
        if ($ship instanceof Ship){
            $ship->asSleep();
        } else {
            echo "error";
        }
    });

    $app->get('/ship/:idShip/weapon/:idWeapon/show', function($idShip, $idWeapon) use ($app){
        $ship = ShipFactory::load($idShip);
        if (!$ship instanceof Ship){
            return false;
        }
        $app->render('include/fire.twig', array('cases' => $ship->getCaseFire($idWeapon), 'ship' => $ship->toArray()));
    });

    $app->get('/ship/:idShip/weapon/:idWeapon/fire', function($idShip, $idWeapon) use ($app){
        $ship = ShipFactory::load($idShip);
        $game = new Game();
        if ($ship instanceof Ship){
            $ship->fire($idWeapon, $game);
        }
    });

    $app->get('/ship/:idShip/weapon/:idWeapon/addCharge', function($idShip, $idWeapon) use ($app){
        $ship = ShipFactory::load($idShip);
        if ($ship instanceof Ship){
            $ship->addCharge($idWeapon);
        }
    });