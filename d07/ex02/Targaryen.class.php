<?php
    class Targaryen
    {
        public function getBurned(){
            if ($this->resistsFire())
                return "emerges maked but unharmed";
            return "burns alive";
        }

        public function resistsFire() {
            return false;
        }
    }