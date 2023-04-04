<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://nikhil.wisdmlabs.net
 * @since      1.0.0
 *
 * @package    Woo_Pickup
 * @subpackage Woo_Pickup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Pickup
 * @subpackage Woo_Pickup/admin
 * @author     Nikhil <nikhil.mhaske@wisdmlabs.com>
 */
class Woo_Pickup_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Pickup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Pickup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-pickup-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Pickup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Pickup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-pickup-admin.js', array('jquery'), $this->version, false);
	}


	// Add custom post type for store locations
	function register_store_post_type()
	{
		$labels = array(
			'name' => __('Pickup Stores'),
			'singular_name' => __('Store'),
			'menu_name' => __('Woo Pickup'),
			'add_new' => __('Add New'),
			'add_new_item' => __('Add New Store'),
			'edit' => __('Edit'),
			'edit_item' => __('Edit Store'),
			'new_item' => __('New Store'),
			'view' => __('View Store'),
			'view_item' => __('View Store'),
			'search_items' => __('Search Stores'),
			'not_found' => __('No stores found'),
			'not_found_in_trash' => __('No stores found in trash'),
		);
		$args = array(
			'labels' => $labels,
			'public' => false,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-store',
			'supports' => array('title'),
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'store'),
		);
		register_post_type('store', $args);
	}
}
