<?php
/**
 * WP Currency Rates installation class.
 *
 * What happens when WP Currency Rates is activated or deactivated.
 *
 * @package WP_Currency_Rates
 */

namespace WP_Softgen_Currency_Rates;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Installation static class.
 *
 * @since 1.0.0
 */
class Install
{

    /**
     * Activate WP Currency Rates.
     *
     * What happens when WP Currency Rates is activated.
     *
     * @since 1.0.0
     */
    public static function activate()
    {

        self::create_tables();

//		$cron = new Cron();
//		$cron->schedule_updates();

        do_action('wp_softgen_currency_rates_activated');

    }

    /**
     * Deactivate WP Currency Rates.
     *
     * What happens when WP Currency Rates is deactivated.
     *
     * @since 1.0.0
     */
    public static function deactivate()
    {

        // Delete options
        delete_option('wp_softgen_currency_rates_settings');

        // Remove WP Currencies cron job.
//		wp_clear_scheduled_hook( 'wp_currencies_update' );

        do_action('wp_softgen_currency_rates_deactivated');

    }

    /**
     * Create currency rates tables.
     *
     * @uses dbDelta()
     * @access private
     *
     * @since 1.0.0
     */
    private static function create_tables()
    {
        global $wpdb;
        $wpdb->hide_errors();
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        // Create tables (if not exist)
        dbDelta(self::create_currency_rates());
        dbDelta(self::create_currency_rates_history());
    }

    /**
     * WP Currency Rates schema.
     *
     * @since 1.0.0
     *
     * @access private
     */
    private static function create_currency_rates()
    {
        global $wpdb;
        $collate = '';
        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset)) {
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }
            if (!empty($wpdb->collate)) {
                $collate .= " COLLATE $wpdb->collate";
            }
        }
        $currency_table = $wpdb->prefix . 'currency_rates';
        return "
CREATE TABLE IF NOT EXISTS `{$currency_table}` (
`currency_code` char(3) NOT NULL PRIMARY KEY,
`buy_price` decimal(10,4) NOT NULL default 0,
`nbg` decimal(10,4) NOT NULL default 0,
`sell_price` decimal(10,4) NOT NULL default 0,
`order_by` int NOT NULL default 10000,
`show_on_main` int NOT NULL default 0,
`last_nbg_update_date` TIMESTAMP ,
`last_update_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) {$collate};";
    }

    /**
     * WP Currency Rates schema.
     *
     * @since 1.0.0
     *
     * @access private
     */
    private static function create_currency_rates_history()
    {
        global $wpdb;
        $collate = '';
        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset)) {
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }
            if (!empty($wpdb->collate)) {
                $collate .= " COLLATE $wpdb->collate";
            }
        }
        $currency_rates_history_table = $wpdb->prefix . 'currency_rates_history';
        return "
CREATE TABLE IF NOT EXISTS `{$currency_rates_history_table}` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  `currency_code` char(3) NOT NULL,
  `buy_price` decimal(10,4) NOT NULL default 0,
  `nbg` decimal(10,4) NOT NULL default 0,
  `sell_price` decimal(10,4) NOT NULL default 0,
  `rate_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) {$collate};";
    }
}
