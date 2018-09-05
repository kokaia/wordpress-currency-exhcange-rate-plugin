<?php
/**
 * WP Softgen Currency Exchange Rates uninstall
 *
 * Fired when the plugin is uninstalled.
 *
 * @package WP_Softgen_Currency_Rates
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit; // exit if accessed directly
}

delete_option( 'wp_softgen_currency_exchange_rates_settings' );

global $wpdb;
$wpdb->hide_errors();

$currency_table = $wpdb->prefix . 'currency_rates';
$currency_rates_history_table = $wpdb->prefix . 'currency_rates_history';

$wpdb->query( "DROP TABLE IF EXISTS {$currency_table};" );
$wpdb->query( "DROP TABLE IF EXISTS {$currency_rates_history_table};" );
