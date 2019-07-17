<?php

/* 
    DEFINE NEW BLOCKS

    - this file is purely for defining your custom acf blocks
    - $blocks array is included from ./index.php


    https://www.advancedcustomfields.com/resources/acf_register_block_type/


    EXAMPLE MINIMUM USE

    $blocks[] = array(
        'title' => __('Test'),
    );
*/


$blocks[] = array(
    'title' => __('Test'),
);

$blocks[] = array(
    'title'     => __('Something'),
    'name'      => 'something-else',
    'icon'      => array(
        'background'    => '#7e70af',
        'foreground'    => '#fff',
        'src'           => 'book-alt',
    ),
    'supports'  => array(),
);