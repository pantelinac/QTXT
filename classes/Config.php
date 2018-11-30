<?php
/**
 * Created by PhpStorm.
 * User: Pantelinac
 * Date: 11/30/2018
 * Time: 8:54 PM
 */

class Config
{
    public static function get($path = null){
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/',$path);

            foreach ($path as $p){
                if(isset($config[$p])){
                    $config = $config[$p];
                }
            }

            return $config;
        }
    }
}