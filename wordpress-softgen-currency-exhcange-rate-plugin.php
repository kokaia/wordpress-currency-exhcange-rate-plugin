<?php
/**
 * @package Currency Exchange rates
 * @version 1.0
 */
/*
Plugin Name: Currency Exchange rates
Plugin URI: https://github.com/kokaia/wordpress-currency-exhcange-rate-plugin
Description: Currency Exchange rates
Author: Giga Kokaia
Version: 1.0
Author URI: http://kokaia.com/
License: GPL
*/


if ( version_compare( PHP_VERSION, '5.4.0', '<') ) {
    add_action( 'admin_notices',
        function() {
            echo '<div class="error"><p>'.
                sprintf( __( "WP Currencies requires PHP 5.4 or above to function properly. Detected PHP version on your server is %s. 
                Please upgrade PHP to activate WP Currencies or remove the plugin.", 'wp_currency_rates' ), phpversion() ? phpversion() : '`undefined`' ) .
                '</p></div>';
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    );
    return;
}

if ( ! class_exists( 'WP_Softgen_Currency_Rates') ) :

    // Useful global constants.
    define( 'WP_CURRENCY_RATES_VERSION', '1.0.0' );
    define( 'WP_CURRENCY_RATES_URL',     plugin_dir_url( __FILE__ ) );
    define( 'WP_CURRENCY_RATES_PATH',    dirname( __FILE__ ) . '/' );
    define( 'WP_CURRENCY_RATES_INC',     WP_CURRENCY_RATES_PATH . 'includes/' );
    define( 'WP_CURRENCY_RATES_ASSERTS', WP_CURRENCY_RATES_URL . 'asserts/' );

    /**
     * WP Currencies main class.
     *
     * @since 1.0.0
     */
    final class WP_Softgen_Currency_Rates {

        /**
         * WP Currencies static instance.
         *
         * @since 1.0.0
         * @access protected
         * @var WP_Softgen_Currency_Rates
         */
        protected static $_instance;

        /**
         * WP Currencies data and rates.
         *
         * @since 1.0.0
         * @access public
         * @var WP_Softgen_Currency_Rates\Currencies
         */
        public $currencies = null;

        /**
         * WP Currencies data and rates.
         *
         * @since 1.0.0
         * @access public
         * @var WP_Softgen_Currency_Rates\Rates
         */
        public $currency_rate = null;

        /**
         * Main WP_Softgen_Currency_Rates instance.
         *
         * Ensures only one instance of WP_Currencies is loaded.
         *
         * @since 1.0.0
         *
         * @return WP_Softgen_Currency_Rates
         */
        public static function get_instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Cloning is forbidden.
         *
         * @since 1.0.0
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cloning the main instance of WP_Currencies is forbidden.', 'wp_currency_rates' ), WP_CURRENCY_RATES_VERSION );
        }

        /**
         * Unserializing instances of this class is forbidden.
         *
         * @since 1.0.0
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of WP_Currencies is forbidden.', 'wp_currency_rates' ), WP_CURRENCY_RATES_VERSION );
        }

        /**
         * Construct.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->includes();
            $this->init();
            $this->currency_rate = new WP_Softgen_Currency_Rates\Rates();
            $this->currencies = new WP_Softgen_Currency_Rates\Currencies();
            do_action( 'wp_softgen_currency_rates_loaded' );
        }

        /**
         * Include WP Currencies library.
         *
         * @since 1.0.0
         *
         * @access private
         */
        private function includes() {
            // Core components.
            include_once WP_CURRENCY_RATES_INC . 'rates.php';
            include_once WP_CURRENCY_RATES_INC . 'functions.php';
//            include_once WP_CURRENCY_RATES_INC . 'cron.php';
            include_once WP_CURRENCY_RATES_INC . 'install.php';
            include_once WP_CURRENCY_RATES_INC . 'Answer.php';
            include_once WP_CURRENCY_RATES_INC . '/currencies/Currencies.php';
            // Admin settings.
//            if ( is_admin() ) {
//                include_once $path . 'settings.php';
//            }
        }

        /**
         * Initialize the plugin.
         *
         * @since 1.0.0
         */

        public function init() {

            // Install.
            register_activation_hook(   __FILE__, array( 'WP_Softgen_Currency_Rates\\Install', 'activate' )  );
            register_deactivation_hook( __FILE__, array( 'WP_Softgen_Currency_Rates\\Install', 'deactivate' ) );

            // Load textdomain.
//            $this->load_plugin_i18n();

            // Advanced Custom Fields (ACF) support.
            //            $enable_acf = apply_filters( 'wp_currencies_enable_acf_support', true );
            //            if ( $enable_acf === true ) {
            ////                 Advanced Custom Fields "Currency" Field (ACF v4.x+).
            //                add_action( 'acf/register_fields', function () {
            //                    include_once WP_CURRENCY_RATES_INC . 'extensions/acf-v4.php';
            //                } );
            //                // Advanced Custom Fields "Currency" Field (ACF v5.x+).
            //                add_action( 'acf/include_field_types', function () {
            //                    include_once WP_CURRENCY_RATES_INC . 'extensions/acf-v5.php';
            //                } );
            //            }

                                    // WP API support.
//                                    $enable_api = apply_filters( 'wp_currencies_enable_api_support', true );
//                                    error_log(print_r($enable_api,true));
//                                    if ( $enable_api === true ) {
            include_once  WP_CURRENCY_RATES_INC . '/extensions/wp-api.php';
            add_action( 'plugins_loaded', array( 'WP_Softgen_Currency_Rates\API', 'get_instance' ) );
            add_action( 'rest_api_init', array( $this, 'api_init' ) );
//                                    }

                                    // Shortcodes.
//                                    $enable_shortcodes = apply_filters( 'wp_currencies_enable_shortcodes', true );
//                                    if ( $enable_shortcodes === true ) {
            include_once WP_CURRENCY_RATES_INC . '/extensions/shortcodes.php';

//                                    }


        }

        /**
         * WP Currencies i18n.
         *
         * @since 1.0.0
         *//*
        public function load_plugin_i18n() {
            $locale = apply_filters( 'plugin_locale', get_locale(), 'wp_softgen_currency_rates' );
            load_textdomain( 'wp_currency_rates', WP_LANG_DIR . '/wp_currency_rates/wp_currency_rates-' . $locale . '.mo' );
            load_plugin_textdomain( 'wp_currency_rates', false, plugin_basename( WP_CURRENCY_RATES_PATH ) . '/languages/' );
        }
*/
        /**
         * Init WP Currencies API extension.
         *
         * @since 1.0.0
         */
        public function api_init() {
            $wp_currencies_api = new WP_Softgen_Currency_Rates\API;
            $wp_currencies_api->register_routes();
        }

        /**
         * Get currencies data.
         *
         * @since 1.0.0
         *
         * @return Object
         */
        public function get_currency_rate($currency) {
            $ans = '';
            if ( $this->currency_rate instanceof WP_Softgen_Currency_Rates\Rates ) {
                $ans = $this->currency_rate->get_currency_rate($currency);
            }
            return apply_filters( 'wp_softgen_currency_rates_get_currency_rate', $ans );
        }

        /**
         * Get currencies data.
         *
         * @since 1.0.0
         *
         * @return array
         */
        public function get_currencies() {
            $currencies = '';
            if ( $this->currency_rate instanceof WP_Softgen_Currency_Rates\Rates ) {
                $currencies = $this->currency_rate->get_currencies();
            }
            return apply_filters( 'wp_softgen_currency_rates_get_currencies', $currencies );
        }

        /**
         * Get exchange rates.
         *
         * @since 1.0.0
         *
         * @return array
         *//*
        public function get_rates() {
            $rates = '';
            if ( $this->currency_rate instanceof WP_Currency_Rates\Rates ) {
                $rates = $this->currency_rate->get_rates();
            }
            return apply_filters( 'wp_currencies_get_rates', $rates );
        }
*/

        /**
         * Get exchange rates.
         *
         * @since 1.0.0
         *
         * @return array
         */
        public function get_currencies_rates() {
            $rates = '';
            if ( $this->currency_rate instanceof WP_Softgen_Currency_Rates\Rates ) {
                $rates = $this->currency_rate->get_currencies_rates();
            }
            return apply_filters( 'wp_softgen_currency_rates_get_currencies_rates', $rates );
        }

        public function get_currency_rates_history($currency_code, $date) {
            $rates = '';
            if ( $this->currency_rate instanceof WP_Softgen_Currency_Rates\Rates ) {
                $rates = $this->currency_rate->get_currency_rates_history($currency_code, $date);
            }
            return apply_filters( 'wp_softgen_currency_rates_get_currency_rates_history', $rates );
        }

    }

else :

    add_action( 'admin_notices',
        function() {
            echo '<div class="error"><p>'.
                sprintf( __( "Plugin conflict: %s has been declared already by another plugin or theme and WP Currencies cannot run properly. 
                Try deactivating other plugins and try again.", 'wp_softgen_currency_rates' ), '`class WP_Softgen_Currency_Rates`' ) .
                '</p></div>';
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    );
    return;

endif;

if ( ! function_exists( 'wp_softgen_currency_rates' ) ) {

    /**
     * Update currencies and exchange rates.
     *
     * Normally this function works as a wp cron scheduled event hook callback.
     * However, if called directly will reschedule the event triggering an update.
     *
     * @internal
     *
     * @since 1.0.0
     */
//    function wp_currencies_update() {
//        $cron = new WP_Currencies\Cron();
//        $cron->cron_update_currencies();
//    }

    /**
     * WP Currencies.
     *
     * @since 1.0.0
     *
     * @return WP_Softgen_Currency_Rates
     */
    function wp_softgen_currency_rates() {
        $wp_currencies = new WP_Softgen_Currency_Rates();
        return $wp_currencies::get_instance();
    }

    // Instantiate.
    wp_softgen_currency_rates();


} else {

    add_action( 'admin_notices',
        function() {
            echo '<div class="error"><p>'.
                sprintf( __( "Plugin conflict: %s has been declared already by another plugin or theme and WP Currencies cannot run properly. 
                Try deactivating other plugins and try again.", 'wp_softgen_currency_rates' ), '`function wp_softgen_currency_rates()`' ) .
                '</p></div>';
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    );

}
