<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    Mondos_Columns
 * @subpackage Mondos_Columns/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mondos_Columns
 * @subpackage Mondos_Columns/includes
 * @author     Elliott Richmond elliott@squareonemd.co.uk
 */
class Mondos_Columns_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		delete_option( 'mondos_posts_columns_options' );

	}

}
