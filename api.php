<?php

// returns gutenberg blocks from post's content
function expose_blocks($content) {
    $raw_blocks = parse_blocks($content);
    $blocks = array();

    foreach ($raw_blocks as $block) {
        if ($block['blockName']) { 
            $block['content'] = render_block($block);
            $blocks[] = $block;
        }
    }

    return $blocks;
}


// add necessary values to revisions rest api
add_filter('rest_prepare_revision', function($response, $post) {
    $data = $response->get_data();
    $data['acf'] = get_fields($post->ID);

    $post = get_post($post->ID);
    $content = $post->post_content;

    $data['blocks'] = expose_blocks($content);

    return rest_ensure_response($data);
}, 10, 2);


// surface gutenberg blocks for all post types in the rest api
add_action('rest_api_init', function() {
    if (!function_exists('use_block_editor_for_post_type')) {
        require ABSPATH . 'wp-admin/includes/post.php';
    }

    $post_types = get_post_types_by_support(['editor']);

    foreach ($post_types as $post_type) {
        if (use_block_editor_for_post_type($post_type)) {
            register_rest_field($post_type, 'blocks',
                [
                    'get_callback' => function(array $post) {
                        $content = $post['content']['raw'];
                        
                        return expose_blocks($content);
                    },
                ]
            );
        }
    }
});