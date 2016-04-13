<?php

    class NightsWatch implements IFighter
    {

        private $soldat = array();

        public function recruit($s)
        {
            $this->soldat[] = $s;
        }

        function fight()
        {
            foreach ($this->soldat as $s) {
                if (method_exists(get_class($s), 'fight'))
                    $s->fight();
            }
        }
    }