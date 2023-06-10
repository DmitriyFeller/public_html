<?php

function print_arr($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

if(!function_exists('mb_str_replace')){

    function mb_str_replace($needle, $text_replace, $haystack){
        return implode($text_replace, explode($needle, $haystack));
    }

}