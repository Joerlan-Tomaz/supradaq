<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('utf8_converter'))
{
    function utf8_converter($array)
	{   
		array_walk_recursive($array, function(&$item, $key){
			if(!mb_detect_encoding($item, 'utf-8', true)){
					$item = utf8_encode($item);
			}
		});
	
		return $array;
    }
}