<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    function generateHash() {
        $key = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hashKey = sha1(rand(100,999).time().$key.rand(100,999));
        return $hashKey;
    }
?>