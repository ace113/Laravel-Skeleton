<?php


// active sidebar link
if (!function_exists('classActivePath')) {

    function classActivePath($path)
    {
        $path = explode('.', $path);
        $segment = 1;

        foreach ($path as $p) {

            if ((request()->segment($segment) == $p) == false) {
                return '';
            }
            $segment++;
        }
        return 'active';
    }

}


if(!function_exists('getSelectedSidebar')){
    function getSelectedSidebar($path){
        $path = explode('.', $path);
        $segment = 1;

        foreach($path as $ph){
            if((request()->segment($segment) == $ph) == false){
                return '';
            }
            $segment++;
        }


        return '<span class="selected"></span>';


    }
}

if (!function_exists('subMenuOpen')) {

    function subMenuOpen($path)
    {

        $path = explode('.', $path);
        $segment = 1;
        foreach ($path as $p) {
            if ((request()->segment($segment) == $p) == false) {
                return '';
            }
            $segment++;
        }
        return 'open';
    }

}
