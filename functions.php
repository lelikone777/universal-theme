<?php

if ( ! function_exists( 'universal_theme_setup' ) ) :
    function universal_theme_setup() {
        //Добавление тэга Title
        add_theme_support( 'title-tag' );

        //Добавление миниатюр
        add_theme_support( 'post-thumbnails', array( 'post' ) );

        //добавление пользовательского логотипа
        add_theme_support( 'custom-logo', [
            'width'       => 190,
            'flex-height' => true,
            'header-text' => 'universal',
            'unlink-homepage-logo' => false, // WP 5.5
        ] );

        //регистрация меню
            register_nav_menus( [
                'header_menu' => 'Header_menu',
                'footer_menu' => 'Footer menu'
            ] );
        
        } 
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

function enqueue_universal_style() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri(  ) . '/assets/css/universal-theme.css', 'style');
    wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}
