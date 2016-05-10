<?php
    $app->get('/control/:id/:player', function($id, $player) use ($app){
        $ship = ShipFactory::load($id);
        if (!$ship instanceof Ship || $ship->getPlayer() != $player)
            return "error";
        $action = array();
        $value = array();
        if ($ship->getSleep() == 0 && $ship->getCurrentActive() == 1) {
            //Phase d'ordre
            if ($ship->getStep() == 0) {
                $value['pp'] = $ship->getCurrentPp();
                $value['speed'] = $ship->getCurrentSpeed();
                $value['shield'] = $ship->getCurrentShield();
                $action['ppSpeed'] = 1;
                $action['ppShield'] = 1;
                $action['ppStop'] = 1;
                //TODO: 1PP Depensé pour une arme donne 1d6 supplémentaire pour tirer avec cette arme.
            } elseif ($ship->getStep() == 1) {
                //TODO: Checker si il est immobile
                $action['rotation'] = 1;
                $action['move'] = array('min' => $ship->getManeuverability(), 'max' => $ship->getCurrentSpeed());
                $action['stopMove'] = 1;
            } elseif ($ship->getStep() == 2) {
                $action['fireStop'] = 1;
                $action['pp'] = $ship->getCurrentPp();
                $action['weapons'] = array();
                foreach($ship->getWeapons() as $w){
                    if ($w->getActive() == 0){
                        $tmp['name'] = $w->getName();
                        $tmp['charge'] = $w->getCharge();
                        $tmp['currentCharge'] = $w->getCurrentCharge();
                        $tmp['id'] = $w->getId();
                        $action['weapons'][] = $tmp;
                    }
                }
            }
        }
        $app->render('include/control.twig', array('action' => $action, 'value' => $value));
    });