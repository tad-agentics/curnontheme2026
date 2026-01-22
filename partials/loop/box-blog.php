<?php 
if( isset( $args['post_object'] ) && !empty( $args['post_object'] ) ){
    $post_object = $args['post_object'];
}else{
    global $post;
    $post_object = $post;
}

$post_title         =   get_the_title( $post_object );
$post_thumbnail     =   get_the_post_thumbnail( $post_object, 'full' ); 
$post_permalink     =   get_the_permalink( $post_object ); 
$post_excerpt       =   get_the_excerpt( $post_object ); ?>