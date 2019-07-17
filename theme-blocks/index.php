<?php

// connect blocks to files
function ms_acf_block_render_callback( $block ) {
    $slug = str_replace('acf/', '', $block['name']);
    
    if (file_exists(get_theme_file_path("/theme-blocks/templates/{$slug}.php"))) {
        if (is_admin()) {
            include(get_theme_file_path("/theme-blocks/templates/{$slug}.php"));
        } else {
            include(get_theme_file_path("/theme-blocks/fields.php"));
        }
    }
}


// register the custom blocks and set them as allowed blocks
function register_blocks($blocks) {
    $allowed_blocks = array();

    foreach($blocks as $args) {
        if ($args['title'] && function_exists('acf_register_block')) {

            // set defaults
            $block = wp_parse_args($args, array(
                'name'              => '',
                'title'             => '',
                'render_callback'   => 'ms_acf_block_render_callback',
                'supports'          => array( 'align' => false ),
                'align'             => 'full',
            ));

            // if 'name' doesn't exist, create it
            if (!$block['name']) {
                $name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $args['title'])));
                $block['name'] = $name;
            }

            // register new block
            acf_register_block($block);

            // add block name to array for the allowed_block_types filter
            $allowed_blocks[] = 'acf/' . $block['name'];

        }
    }

    // remove default gutenberg blocks and include new custom blocks
    add_filter( 'allowed_block_types', function() use ($allowed_blocks) {
        return $allowed_blocks;
    });
}


// define array of custom blocks
$blocks = array();

// include custom block definitions
require_once(get_stylesheet_directory() . '/theme-blocks/blocks.php');

// register all custom blocks
register_blocks($blocks);
