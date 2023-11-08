<?php
/**
 * Plugin Name:           GamiPress - WooCommerce Shipstation integration
 * Plugin URI:            https://wordpress.org/plugins/gamipress-woocommerce-shipstation-integration/
 * Description:           Connect GamiPress with WooCommerce Shipstation.
 * Version:               1.0.0
 * Author:                GamiPress
 * Author URI:            https://gamipress.com/
 * Text Domain:           gamipress-woocommerce-shipstation-integration
 * Domain Path:           /languages/
 * Requires at least:     4.4
 * Tested up to:          6.3
 * License:               GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package               GamiPress\WooCommerce_Shipstation
 * @author                GamiPress
 * @copyright             Copyright (c) GamiPress
 */

final class GamiPress_Integration_WooCommerce_Shipstation {

    /**
     * @var         GamiPress_Integration_WooCommerce_Shipstation $instance The one true GamiPress_Integration_WooCommerce_Shipstation
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Integration_WooCommerce_Shipstation self::$instance The one true GamiPress_Integration_WooCommerce_Shipstation
     */
    public static function instance() {

        if( !self::$instance ) {
            self::$instance = new GamiPress_Integration_WooCommerce_Shipstation();
            self::$instance->constants();
            self::$instance->includes();
            self::$instance->hooks();
        }

        return self::$instance;
    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {
        // Plugin version
        define( 'GAMIPRESS_WOOCOMMERCE_SHIPSTATION_VER', '1.0.0' );

        // Plugin path
        define( 'GAMIPRESS_WOOCOMMERCE_SHIPSTATION_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_WOOCOMMERCE_SHIPSTATION_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_WOOCOMMERCE_SHIPSTATION_DIR . 'includes/admin.php';
            require_once GAMIPRESS_WOOCOMMERCE_SHIPSTATION_DIR . 'includes/listeners.php';
            require_once GAMIPRESS_WOOCOMMERCE_SHIPSTATION_DIR . 'includes/triggers.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {
        // Setup our activation and deactivation hooks
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        
    }

    /**
     * Activation hook for the plugin.
     *
     * @since  1.0.0
     */
    function activate() {

        if( $this->meets_requirements() ) {

        }

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    function deactivate() {

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( ! class_exists( 'GamiPress' ) )
            return false;

        // Requirements on multisite install
        if( is_multisite() && gamipress_is_network_wide_active() && is_main_site() ) {

            // On main site, need to check if integrated plugin is installed on any sub site to load all configuration files
            if( gamipress_is_plugin_active_on_network( 'woocommerce-shipstation-integration/woocommerce-shipstation.php' ) ) {
                return true;
            }

        }

        if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'woocommerce_shipstation_init' ) ) {
            return false;
        }

        return true;

    }

}

/**
 * The main function responsible for returning the one true GamiPress_Integration_WooCommerce_Shipstation instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Integration_WooCommerce_Shipstation The one true GamiPress_Integration_WooCommerce_Shipstation
 */
function GamiPress_Integration_WooCommerce_Shipstation() {
    return GamiPress_Integration_WooCommerce_Shipstation::instance();
}
add_action( 'gamipress_pre_init', 'GamiPress_Integration_WooCommerce_Shipstation' );
