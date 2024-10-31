<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://beeplugins.com
 * @since             1.0.0
 * @package           Wpr_Scroller
 *
 * @wordpress-plugin
 * Plugin Name:       wordpress responsive scroller
 * Plugin URI:        http://beeplugins.com
 * Description:       A simple wordpress responsive scroller which is used to scroll posts horizontally.
 * Version:           1.0.0
 * Author:            aumsrini
 * Author URI:        http://beeplugins.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpr-scroller
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpr-scroller-activator.php
 */

function activate_wpr_scroller() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpr-scroller-activator.php';
		
	Wpr_Scroller_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpr-scroller-deactivator.php
 */
function deactivate_wpr_scroller() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpr-scroller-deactivator.php';
	Wpr_Scroller_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpr_scroller' );
register_deactivation_hook( __FILE__, 'deactivate_wpr_scroller' );



/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpr-scroller.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpr_scroller() {

	$plugin = new Wpr_Scroller();
	$plugin->run();
	
function wpr_func( $atts ){

	echo'<div class="TickerNews default_theme" id="T1">
  <div class="ti_wrapper">
    <div class="ti_slide">
      <div class="ti_content">';
	  
	  $wpr_settings=get_option( 'wpr_scroller_option' );
	  
	  $no_posts= $wpr_settings['no_post'];
		
		 $args = array( 'numberposts' => $no_posts,'post_type' => 'wpr_scroller_news' );
        $recent_posts = wp_get_recent_posts( $args );

        foreach( $recent_posts as $recent ){
		
		$wpr_news_title = strip_tags($recent["post_title"]);
		
		$wpr_news_content = strip_tags($recent["post_content"],100);
		
		
            echo '<div class="ti_news">'.$wpr_news_content.'<a href="#">Read More</a>  </div>';
        }
		
      echo'

	
        
      </div>
    </div>
  </div>
</div><script type="text/javascript">

	 jQuery(document).ready(function(){
	 
	 

				jQuery("#T1").newsTicker();


				jQuery("#T1").hover(
  function(handlerIn) {jQuery("#T1").stopTicker();},function(handlerOut) {jQuery("#T1").newsTicker();}
);
	  
});
	    </script>';
}
add_shortcode( 'wpr_scroller', 'wpr_func' );

}

run_wpr_scroller();

///News Section
// Register the Custom Music Review Post Type
 
function register_cpt_scroller_news() {
 
    $labels = array(
        'name' => _x( 'Scroller News', 'wpr_scroller_news' ),
        'singular_name' => _x( 'Scroller News', 'wpr_scroller_news' ),
        'add_new' => _x( 'Add News', 'wpr_scroller_news' ),
        'add_new_item' => _x( 'Add New News', 'wpr_scroller_news' ),
        'edit_item' => _x( 'Edit News ', 'wpr_scroller_news' ),
        'new_item' => _x( 'New News', 'wpr_scroller_news' ),
        'view_item' => _x( 'View News', 'wpr_scroller_news' ),
        'search_items' => _x( 'Search Scroller News', 'wpr_scroller_news' ),
        'not_found' => _x( 'No news found', 'wpr_scroller_news' ),
        'not_found_in_trash' => _x( 'No News found in Trash', 'wpr_scroller_news' ),
        'parent_item_colon' => _x( 'Parent News:', 'wpr_scroller_news' ),
        'menu_name' => _x( 'Scroller News', 'wpr_scroller_news' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Scroller News filterable by category',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'categories' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-menu',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'wpr_scroller_news', $args );
}
 
add_action( 'init', 'register_cpt_scroller_news' );


function categorys_taxonomy() {
    register_taxonomy(
        'categorys',
        'wpr_scroller_news',
        array(
            'hierarchical' => true,
            'label' => 'News Category',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'category',
                'with_front' => false
            )
        )
    );
}
add_action( 'init', 'categorys_taxonomy');
