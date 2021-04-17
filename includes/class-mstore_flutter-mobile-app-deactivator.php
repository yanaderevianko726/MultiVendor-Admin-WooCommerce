<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://mstoreapp.com
 * @since      1.0.0
 *
 * @package    Mstore_Flutter_Mobile_App
 * @subpackage Mstore_Flutter_Mobile_App/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mstore_Flutter_Mobile_App
 * @subpackage Mstore_Flutter_Mobile_App/includes
 * @author     Mstoreapp <support@mstoreapp.com>
 */
class Mstore_Flutter_Mobile_App_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

	  // Remove the rewrite rule on deactivation
	  global $wp_rewrite;
	  $wp_rewrite->flush_rules();

	}

}
