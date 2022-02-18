<?php  

if (!defined('BASEPATH')) exit('Nenhum acesso de script direto permitido');

    define("CACHE_DIR", APPPATH.'cache/');

    if (!function_exists('ExisteCache')) {
        
        function ExisteCache($cache_name, $lifespan) {

            if (file_exists(CACHE_DIR.$cache_name)) {
                $last_date = file_get_contents(CACHE_DIR.$cache_name);
                if (abs($last_date - time()) < $lifespan) {
                    return true;
                } else {
                    file_put_contents(CACHE_DIR.$cache_name,time());
                    return false;
                }
            } else {
                file_put_contents(CACHE_DIR.$cache_name,time());
                return true;
            }
        }

    }