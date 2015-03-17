<?php

// Register Widgets
function tj_widgets_init() {

	// Sidebar
	register_sidebar( array (
		'name' => __( 'Sidebar', 'themejunkie' ),
		'id' => 'sidebar',
		'description' => __( 'Sidebar', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Footer Widget Area 1
	register_sidebar( array (
		'name' => __( 'Footer Widget Area 1', 'themejunkie' ),
		'id' => 'footer-widget-area-1',
		'description' => __( 'The bottom widget area', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Footer Widget Area 2
	register_sidebar( array (
		'name' => __( 'Footer Widget Area 2', 'themejunkie' ),
		'id' => 'footer-widget-area-2',
		'description' => __( 'The bottom widget area', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Footer Widget Area 3
	register_sidebar( array (
		'name' => __( 'Footer Widget Area 3', 'themejunkie' ),
		'id' => 'footer-widget-area-3',
		'description' => __( 'The bottom widget area', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Footer Widget Area 4
	register_sidebar( array (
		'name' => __( 'Footer Widget Area 4', 'themejunkie' ),
		'id' => 'footer-widget-area-4',
		'description' => __( 'The bottom widget area', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	

	// Footer Widget Area 5
	register_sidebar( array (
		'name' => __( 'Footer Widget Area 5', 'themejunkie' ),
		'id' => 'footer-widget-area-5',
		'description' => __( 'The bottom widget area', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
}
add_action( 'init', 'tj_widgets_init' );

?>