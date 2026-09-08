<?php
/**
 * Plugin Name: BVOS Elite Performance
 * Description: Subscription-based basketball development portal for BVOS Basketball.
 * Version: 0.1.0
 * Author: BVOS Basketball
 * Text Domain: bvos-elite-performance
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BVOS_EP_VERSION', '0.1.0' );
define( 'BVOS_EP_FILE', __FILE__ );
define( 'BVOS_EP_PATH', plugin_dir_path( __FILE__ ) );
define( 'BVOS_EP_URL', plugin_dir_url( __FILE__ ) );

require_once BVOS_EP_PATH . 'includes/class-bvos-elite-performance.php';

register_activation_hook( __FILE__, array( 'BVOS_Elite_Performance', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'BVOS_Elite_Performance', 'deactivate' ) );

function bvos_elite_performance() {
    return BVOS_Elite_Performance::instance();
}

bvos_elite_performance();
