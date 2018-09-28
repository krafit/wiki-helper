<?php
/*
Plugin Name: Wiki-Helper
Plugin URI: https://github.com/krafit/wiki-helper/
Description: Lets use WordPress for documentation 🎉.
Author: Simon Kraft
Author URI: https://simonkraft.de
Version: 0.1.0
Tested up to: 4.9
Text Domain: 'wiki-helper'
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /lang/
*/

// Load text domain.
function wiki_load_textdomain() {
	load_plugin_textdomain( 'wiki-helper', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}

add_action( 'init', 'wiki_load_textdomain' );


// Register Custom Taxonomy "collection"
function wiki_collection() {

	$labels = array(
		'name' => _x( 'Collections', 'Taxonomy General Name', 'wiki-helper' ),
		'singular_name' => _x( 'Collection', 'Taxonomy Singular Name', 'wiki-helper' ),
		'menu_name' => __( 'Collections', 'wiki-helper' ),
		'all_items' => __( 'All Collections', 'wiki-helper' ),
		'parent_item' => __( 'Parent Collection', 'wiki-helper' ),
		'parent_item_colon' => __( 'Parent Collection:', 'wiki-helper' ),
		'new_item_name' => __( 'New Collection Name', 'wiki-helper' ),
		'add_new_item' => __( 'Add new Collection', 'wiki-helper' ),
		'edit_item' => __( 'Edit Collection', 'wiki-helper' ),
		'update_item' => __( 'Update Collection', 'wiki-helper' ),
		'view_item' => __( 'View Collection', 'wiki-helper' ),
		'separate_items_with_commas' => __( 'Separate Collection with commas', 'wiki-helper' ),
		'add_or_remove_items' => __( 'Add or remove Collections', 'wiki-helper' ),
		'choose_from_most_used' => __( 'Choose from the most used', 'wiki-helper' ),
		'popular_items' => __( 'Popular Collections', 'wiki-helper' ),
		'search_items' => __( 'Search Collections', 'wiki-helper' ),
		'not_found' => __( 'Not Found', 'wiki-helper' ),
		'no_terms' => __( 'No Collections', 'wiki-helper' ),
		'items_list' => __( 'Collection list', 'wiki-helper' ),
		'items_list_navigation' => __( 'Collection list navigation', 'wiki-helper' ),
	);
	$rewrite = array(
		'slug' => 'collection',
		'with_front' => true,
		'hierarchical' => true,
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => false,
		'rewrite' => $rewrite,
		'show_in_rest' => true,
	);
	register_taxonomy( 'collection', array( 'page' ), $args );

}

add_action( 'init', 'wiki_collection', 0 );


// Register Custom Taxonomy "partial"
function wiki_partial() {

	$labels = array(
		'name' => _x( 'Partials', 'Taxonomy General Name', 'wiki-helper' ),
		'singular_name' => _x( 'Partial', 'Taxonomy Singular Name', 'wiki-helper' ),
		'menu_name' => __( 'Partials', 'wiki-helper' ),
		'all_items' => __( 'All Partials', 'wiki-helper' ),
		'parent_item' => __( 'Parent Partial', 'wiki-helper' ),
		'parent_item_colon' => __( 'Parent Partial:', 'wiki-helper' ),
		'new_item_name' => __( 'New Partial Name', 'wiki-helper' ),
		'add_new_item' => __( 'Add new Partial', 'wiki-helper' ),
		'edit_item' => __( 'Edit Partial', 'wiki-helper' ),
		'update_item' => __( 'Update Partial', 'wiki-helper' ),
		'view_item' => __( 'View Partial', 'wiki-helper' ),
		'separate_items_with_commas' => __( 'Separate Partial with commas', 'wiki-helper' ),
		'add_or_remove_items' => __( 'Add or remove Partials', 'wiki-helper' ),
		'choose_from_most_used' => __( 'Choose from the most used', 'wiki-helper' ),
		'popular_items' => __( 'Popular Partials', 'wiki-helper' ),
		'search_items' => __( 'Search Partials', 'wiki-helper' ),
		'not_found' => __( 'Not Found', 'wiki-helper' ),
		'no_terms' => __( 'No Partials', 'wiki-helper' ),
		'items_list' => __( 'Partial list', 'wiki-helper' ),
		'items_list_navigation' => __( 'Partial list navigation', 'wiki-helper' ),
	);
	$rewrite = array(
		'slug' => 'partial',
		'with_front' => true,
		'hierarchical' => true,
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => false,
		'rewrite' => $rewrite,
		'show_in_rest' => true,
	);
	register_taxonomy( 'partial', array( 'page' ), $args );

}

add_action( 'init', 'wiki_partial', 0 );
 

// Add categories to pages
function wiki_add_categories() {
	register_taxonomy_for_object_type( 'category', 'page' );
}

add_action( 'init', 'wiki_add_categories' );


// Allow comments for pages by default
function wiki_allow_comments( $status, $post_type, $comment_type ) {
	if ( 'page' === $post_type ) {
		if ( in_array( $comment_type, array( 'pingback', 'trackback' ) ) ) {
			$status = get_option( 'default_ping_status' );
		} else {
			$status = get_option( 'default_comment_status' );
		}
	}

	return $status;
}

add_filter( 'get_default_comment_status', 'wiki_allow_comments', 10, 3 );