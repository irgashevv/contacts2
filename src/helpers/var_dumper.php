<?php

function dd($var, $die = true)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';

    if ($die) {
        die();
    }
}