<?php

    if (!class_exists('ReduxFramework') && file_exists(plugin_dir_path(__FILE__) . '/admin/optionspanel/framework.php')) {
        require_once ('admin/optionspanel/framework.php');
    }
 
    if (!isset($redux_demo) && file_exists(plugin_dir_path(__FILE__) . '/admin/optionspanel/config.php')) {
        require_once ('admin/optionspanel/config.php');
    }

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://mstoreapp.com
 * @since             1.0.0
 * @package           Mstore_Flutter_Mobile_App
 *
 * @wordpress-plugin
 * Plugin Name:       Mstore Flutter Mobile App
 * Plugin URI:        http://mstoreapp.com
 * Description:       Connects Mstore Mobile app with api.
 * Version:           1.0.1
 * Author:            Mstoreapp
 * Author URI:        http://mstoreapp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mstore_flutter-mobile-app
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
        
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mstore_flutter-mobile-app-activator.php
 */
function activate_mstore_flutter_mobile_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mstore_flutter-mobile-app-activator.php';
	Mstore_Flutter_Mobile_App_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mstore_flutter-mobile-app-deactivator.php
 */
function deactivate_mstore_flutter_mobile_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mstore_flutter-mobile-app-deactivator.php';
	Mstore_Flutter_Mobile_App_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mstore_flutter_mobile_app' );
register_deactivation_hook( __FILE__, 'deactivate_mstore_flutter_mobile_app' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mstore_flutter-mobile-app.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mstore_flutter_mobile_app() {

$object_type = 'post';
$args1 = array(
    'type'         => 'integer',
    'description'  => 'Like count for a post.',
    'single'       => true,
    'show_in_rest' => true,
);
register_meta( $object_type, 'likes', $args1 );


function register_rest_props(){
    register_rest_field( array('post'),
        'featuredUrl',
        array(
            'get_callback'    => 'get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( array('post'),
        'authorDetails',
        array(
            'get_callback'    => 'get_rest_auther_name',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( array('post'),
        'featuredDetails',
        array(
            'get_callback'    => 'get_rest_featured_image_details',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( array('post'),
        'excerptData',
        array(
            'get_callback'    => 'get_rest_excerpt',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( array('post'),
        'commentCount',
        array(
            'get_callback'    => 'get_rest_comment_count',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
function get_rest_featured_image( $object, $field_name, $request ) {
    //if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
        return $img[0];
   // }
    return false;
}

function get_rest_featured_image_details( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_metadata( $object['featured_media'] );
        return $img;
    }
    return null;
}

function get_rest_excerpt( $object, $field_name, $request ) {
        $excerpt = get_the_excerpt($object);
        if($excerpt != null)
        return $excerpt;
        return '';
}

function get_rest_auther_name( $object, $field_name, $request ) {
    if( $object['author'] ){
        $user_info = get_userdata($object['author']);
        $data = array (
            'name' => $user_info->last_name .  " " . $user_info->first_name,
            'avatar' => get_avatar_url($object['author'])
        );
        return $data;
    }
    return false;
}

function get_rest_comment_count( $object, $field_name, $request ) {
    if( $object ){
        $count = get_comments_number( $object['id'] );
        return $count;
    }
    return 0;
}

	$plugin = new Mstore_Flutter_Mobile_App();
	$plugin->run();

}
run_mstore_flutter_mobile_app();
