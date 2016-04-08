<?php
    function ft_split($str){
        $ret = array_filter(explode(' ', $str));
        sort($ret);
        return $ret;
    }