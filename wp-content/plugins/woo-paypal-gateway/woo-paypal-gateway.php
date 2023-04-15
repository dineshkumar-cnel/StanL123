<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Payment Gateway for PayPal on WooCommerce
 * Plugin URI:        https://profiles.wordpress.org/easypayment
 * Description:       Easily enable PayPal payment methods for WooCommerce.
 * Version:           7.1.6
 * Author:            easypayment
 * Author URI:        https://profiles.wordpress.org/easypayment/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       woo-paypal-gateway
 * Domain Path:       /languages
 * Requires at least: 5.3
 * Requires PHP: 7.0
 * Tested up to: 6.1.1
 * WC requires at least: 3.0.0
 * WC tested up to: 7.4.1
 */
if (!defined('WPINC')) {
    die;
}

define('WPG_PLUGIN_VERSION', '7.1.6');
if (!defined('WPG_PLUGIN_PATH')) {
    define('WPG_PLUGIN_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
}
if (!defined('WPG_PLUGIN_DIR')) {
    define('WPG_PLUGIN_DIR', dirname(__FILE__));
}
if (!defined('WPG_PLUGIN_BASENAME')) {
    define('WPG_PLUGIN_BASENAME', plugin_basename(__FILE__));
}
if (!defined('WPG_PLUGIN_ASSET_URL')) {
    define('WPG_PLUGIN_ASSET_URL', plugin_dir_url(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-paypal-gateway-activator.php
 */
function activate_woo_paypal_gateway() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-paypal-gateway-activator.php';
    Woo_Paypal_Gateway_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-paypal-gateway-deactivator.php
 */
function deactivate_woo_paypal_gateway() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-paypal-gateway-deactivator.php';
    Woo_Paypal_Gateway_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_paypal_gateway');
register_deactivation_hook(__FILE__, 'deactivate_woo_paypal_gateway');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . '/ppcp/includes/class-ppcp-paypal-checkout-for-woocommerce.php';
require plugin_dir_path(__FILE__) . 'includes/class-woo-paypal-gateway.php';

/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
function run_woo_paypal_gateway() {
    $plugin = new Woo_Paypal_Gateway();
    $plugin->run();
}

function init_wpg_woo_paypal_gateway_class() {
    if (class_exists('WC_Payment_Gateway')) {
        run_ppcp_paypal_checkout_for_woocommerce();
    }
    run_woo_paypal_gateway();
}

add_action('plugins_loaded', 'init_wpg_woo_paypal_gateway_class', 11);

if (!function_exists('run_ppcp_paypal_checkout_for_woocommerce')) {
    run_ppcp_paypal_checkout_for_woocommerce();
}

function run_ppcp_paypal_checkout_for_woocommerce() {
    $plugin = new PPCP_Paypal_Checkout_For_Woocommerce();
    $plugin->run();
}
