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


	// Save store details meta box data
	function save_store_details_meta_box_data($post_id)
	{
		if (!isset($_POST['store_details_nonce']) || !wp_verify_nonce($_POST['store_details_nonce'], 'save_store_details')) {
			return;
		}
		if (isset($_POST['store_name'])) {
			update_post_meta($post_id, '_store_name', sanitize_text_field($_POST['store_name']));
		}
		if (isset($_POST['store_address'])) {
			update_post_meta($post_id, '_store_address', sanitize_textarea_field($_POST['store_address']));
		}
		if (isset($_POST['store_phone'])) {
			update_post_meta($post_id, '_store_phone', sanitize_text_field($_POST['store_phone']));
		}
		if (isset($_POST['store_email'])) {
			update_post_meta($post_id, '_store_email', sanitize_email($_POST['store_email']));
		}
		if (isset($_POST['store_location_url'])) {
			update_post_meta($post_id, '_store_location_url', esc_url_raw($_POST['store_location_url']));
		}
	}



	// Add pickup store dropdown and date picker to checkout page
	function add_pickup_store_to_checkout($checkout)
	{
		$pickup_stores = get_posts(array(
			'post_type' => 'store',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC'
		));
		if ($pickup_stores) {
			echo '<div id="pickup_store">';
			woocommerce_form_field('pickup_store', array(
				'type' => 'select',
				'label' => __('Pickup Store', 'woo-pickup'),
				'required' => true,
				'options' => array(
					'' => __('Select Pickup Store', 'woo-pickup')
				) + wp_list_pluck($pickup_stores, 'post_title', 'ID')
			), $checkout->get_value('pickup_store'));
			echo '</div>';
			echo '<div id="pickup_date">';
			woocommerce_form_field('pickup_date', array(
				'type' => 'date',
				'label' => __('Pickup Date', 'woo-pickup'),
				'required' => true,
				'autocomplete' => 'off'
			), $checkout->get_value('pickup_date'));
			echo '</div>';
		}
	}

	// Validate pickup store and date fields
	function validate_pickup_store_and_date_fields()
	{
		if (!$_POST['pickup_store'] || $_POST['pickup_store'] == '') {
			wc_add_notice(__('Please select a pickup store.', 'woo-pickup'), 'error');
		}
		if (!$_POST['pickup_date'] || $_POST['pickup_date'] == '') {
			wc_add_notice(__('Please select a pickup date.', 'woo-pickup'), 'error');
		}
	}

	// Save pickup store and date fields to order meta data
	function save_to_order_meta_data($order)
	{
		if ($_POST['pickup_store'] && $_POST['pickup_store'] != '') {
			$order->update_meta_data('_pickup_store', sanitize_text_field($_POST['pickup_store']));
		}
		if ($_POST['pickup_date'] && $_POST['pickup_date'] != '') {
			$order->update_meta_data('_pickup_date', sanitize_text_field($_POST['pickup_date']));
		}
	}



	// Add "Ready to Pickup" order status
	function add_ready_to_pickup_order_status($order_statuses)
	{
		$order_statuses['wc-ready-to-pickup'] = __('Ready to Pickup', 'woo-pickup');
		return $order_statuses;
	}

	// Add pickup store details to order admin page
	function order_admin_page_modifications($order)
	{
		$pickup_store = $order->get_meta('_pickup_store');
		$pickup_date = $order->get_meta('_pickup_date');
		if ($pickup_store && $pickup_store != '') {

			echo '<div class="pickup-store-details">';
			echo '<h2>' . __('Pickup Store Details', 'woo-pickup') . '</h2>';
			$store = get_post($pickup_store);
			echo '<p><strong>' . __('Store Name', 'woo-pickup') . ':</strong> ' . esc_html($store->post_title) . '</p>';
			echo '<p><strong>' . __('Address', 'woo-pickup') . ':</strong> ' . esc_html(get_post_meta($pickup_store, '_store_address', true)) . '</p>';
			echo '<p><strong>' . __('Phone', 'woo-pickup') . ':</strong> ' . esc_html(get_post_meta($pickup_store, '_store_phone', true)) . '</p>';
			echo '<p><strong>' . __('Email', 'woo-pickup') . ':</strong> ' . esc_html(get_post_meta($pickup_store, '_store_email', true)) . '</p>';
			echo '<p><strong>' . __('Location URL', 'woo-pickup') . ':</strong> ' . esc_url(get_post_meta($pickup_store, '_store_location_url', true)) . '</p>';
			if ($pickup_date && $pickup_date != '') {
				echo '<p><strong>' . __('Pickup Date', 'woo-pickup') . ':</strong> ' . esc_html($pickup_date) . '</p>';
			}
			echo '</div>';
		}
	}

	// Add pickup store details to order confirmation email
	function add_store_details_to_confirmation_mail($order, $sent_to_admin, $plain_text, $email)
	{
		$pickup_store = $order->get_meta('_pickup_store');
		$pickup_date = $order->get_meta('_pickup_date');
		if ($pickup_store && $pickup_store != '') {
			$store = get_post($pickup_store);
			echo '<h2>' . __('Pickup Store', 'woo-pickup') . '</h2>';
			echo '<div>';
			echo '<p><strong>' . __('Store Name', 'woo-pickup') . ':</strong> ' . esc_html($store->post_title) . '</p>';
			echo '<p><strong>' . __('Address', 'woo-pickup') . ':</strong> ' . esc_html(get_post_meta($pickup_store, '_store_address', true)) . '</p>';
			echo '<p><strong>' . __('Phone', 'woo-pickup') . ':</strong> ' . esc_html(get_post_meta($pickup_store, '_store_phone', true)) . '</p>';
			echo '<p><strong>' . __('Email', 'woo-pickup') . ':</strong> ' . esc_html(get_post_meta($pickup_store, '_store_email', true)) . '</p>';
			echo '<p><strong>' . __('Location URL', 'woo-pickup') . ':</strong> ' . esc_url(get_post_meta($pickup_store, '_store_location_url', true)) . '</p>';
		}
		if ($pickup_date && $pickup_date != '') {
			echo '<h2>' . __('Pickup Date', 'woo-pickup') . '</h2>';
			echo '<p>' . esc_html($pickup_date) . '</p>';
		}
	}

	// Notify store owner when order is received
	function notify_store_owner_for_receiving_order($order_id)
	{

		$order = wc_get_order($order_id);
		global $admin_email;
		$admin_email = get_option('admin_email');
		$customer_id = $order->get_customer_id();

		if ($customer_id) {
			$customer = new WC_Customer($customer_id);

			$customer_email = $customer->get_email();
			$customer_first_name = $customer->get_first_name();
			$customer_last_name = $customer->get_last_name();
			$customer_phone = $customer->get_billing_phone();
		} else {
			$customer_email = $order->get_billing_email();
			$customer_first_name = $order->get_billing_first_name();
			$customer_last_name = $order->get_billing_last_name();
			$customer_phone = $order->get_billing_phone();
		}


		$pickup_store = $order->get_meta('_pickup_store');
		$pickup_date = $order->get_meta('_pickup_date');

		if ($pickup_store && $pickup_store != '') {
			$store = get_post($pickup_store);
			$store_owner_email = get_post_meta($pickup_store, '_store_email', true);
			if ($store_owner_email && $store_owner_email != '') {
				$subject = sprintf(__('You Received Pickup Store order #%s', 'woo-pickup'), $order->get_order_number());
				$message = '';
				$message .= 'Hey, ' . $store->post_title . "\n";
				$message .= 'Your store received a Pickup Order ' . $order->get_order_number() . "\n";
				$message .= 'Order Details: ' . "\n";
				$message .= 'Pickup Date: ' . $pickup_date . "\n";
				$message .= 'Customer Name: ' . $customer_first_name . ' ' . $customer_last_name . "\n";
				$message .= 'Customer Email: ' . $customer_email . "\n";
				$message .= 'Customer Phone No: ' . $customer_phone . "\n\n";
				$message .= 'Customer will be notified when order status changed to Ready To Pickup!';
				$headers = array(
					'From: ' . $admin_email
				);
				wp_mail($store_owner_email, $subject, $message, $headers);
			}
		}
	}


	// Send email to customer when order status is changed to "Ready To Pickup"

	function check_for_ready_to_pickup($order_id, $old_status, $new_status, $order)
	{

		if ($new_status == 'ready-to-pickup' && $old_status != 'ready-to-pickup') {
			$this->ready_to_pickup_notification($order_id);
		} else {
			//You can add multiple email on different actions of order status
		}
	}

	function ready_to_pickup_notification($order_id)
	{
		$order = wc_get_order($order_id);

		$customer_id = $order->get_customer_id();

		if ($customer_id) {
			$customer = new WC_Customer($customer_id);
			$customer_email = $customer->get_email();
			$customer_first_name = $customer->get_first_name();
		} else {
			$customer_email = $order->get_billing_email();
			$customer_first_name = $order->get_billing_first_name();
		}


		$pickup_store = $order->get_meta('_pickup_store');
		$pickup_date = $order->get_meta('_pickup_date');

		if ($pickup_store && $pickup_store != '') {
			$store = get_post($pickup_store);
			$store_owner_email = get_post_meta($pickup_store, '_store_email', true);
			if ($store_owner_email && $store_owner_email != '') {
				$subject = sprintf(__('Knock Knock! Your order #%s is Ready to Pickup', 'woo-pickup'), $order->get_order_number());
				$message = '';
				$message .= 'Hey, ' . $customer_first_name . "\n";
				$message .= 'Your order ' . $order->get_order_number() . ' is Ready to Pickup at Store ' . $store->post_title . "\n";
				$message .= 'Order Details-> ' . "\n";
				$message .= 'Pickup Date: ' . $pickup_date . "\n";
				$message .= 'Customer Name: ' . $customer_first_name . "\n";
				$message .= 'Customer Email: ' . $customer_email . "\n\n";

				$message .= 'Pickup Store Details->' . "\n";
				$message .= 'Store Name: ' . $store->post_title . "\n";
				$message .= 'Address: ' . esc_html(get_post_meta($pickup_store, '_store_address', true)) . "\n";
				$message .= 'Contact: ' . esc_html(get_post_meta($pickup_store, '_store_phone', true)) . "\n";
				$message .= 'Email: ' . esc_html(get_post_meta($pickup_store, '_store_email', true)) . "\n";
				$message .= 'Location: ' . esc_html(get_post_meta($pickup_store, '_store_location_url', true)) . "\n\n";
				$message .= 'Please Make sure you carry Identity proof at time of pickup!';

				$headers = array(
					'From: ' . $store_owner_email
				);
				wp_mail($customer_email, $subject, $message, $headers);
			}
		}
	}
}
