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

	// Add store details meta box to store post type
	function add_store_details_meta_box()
	{
		add_meta_box(
			'store_details_meta_box',
			__('Store Details', 'woo-pickup'),
			array($this, 'render_store_details_meta_box'),
			'store',
			'normal',
			'default'
		);
	}


	// Render store details meta box
	function render_store_details_meta_box($post)
	{
		wp_nonce_field('save_store_details', 'store_details_nonce');
		$store_name = get_post_meta($post->ID, '_store_name', true);
		$store_address = get_post_meta($post->ID, '_store_address', true);
		$store_phone = get_post_meta($post->ID, '_store_phone', true);
		$store_email = get_post_meta($post->ID, '_store_email', true);
		$store_location_url = get_post_meta($post->ID, '_store_location_url', true);
		echo '<p><label for="store_name">' . __('Store Name', 'woo-pickup') . '</label><br>';
		echo '<input type="text" id="store_name" name="store_name" value="' . esc_attr($store_name) . '"></p>';
		echo '<p><label for="store_address">' . __('Store Address', 'woo-pickup') . '</label><br>';
		echo '<textarea id="store_address" name="store_address">' . esc_textarea($store_address) . '</textarea></p>';
		echo '<p><label for="store_phone">' . __('Store Phone', 'woo-pickup') . '</label><br>';
		echo '<input type="text" id="store_phone" name="store_phone" value="' . esc_attr($store_phone) . '"></p>';
		echo '<p><label for="store_email">' . __('Store Email', 'woo-pickup') . '</label><br>';
		echo '<input type="text" id="store_email" name="store_email" value="' . esc_attr($store_email) . '"></p>';
		echo '<p><label for="store_location_url">' . __('Store Location URL', 'woo-pickup') . '</label><br>';
		echo '<input type="text" id="store_location_url" name="store_location_url" value="' . esc_attr($store_location_url) . '"></p>';
	}
}
