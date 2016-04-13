<?php

    /**
     * Created by PhpStorm.
     * User: adespond
     * Date: 4/11/16
     * Time: 4:29 PM
     */
    class Jaime
    {
        public function sleepWith($a)
        {
            if ($a instanceof Tyrion)
                print("Not event if I'm drunk !" .PHP_EOL);
            else if ($a instanceof Sansa)
                print("Let's do this." .PHP_EOL);
            else if ($a instanceof Cersei)
                print("With pleasure, but only in a tower in Winterfell, them." .PHP_EOL);
        }
    }