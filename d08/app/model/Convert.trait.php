<?php

    trait Convert
    {
        public function jsonSerialize()
        {
            return json_encode(get_object_vars($this));
        }

        public function toArray()
        {
            return get_object_vars($this);
        }
    }