<?php
/**
 * Exchange Rates
 *
 * Handling of currency data and exchange rates.
 *
 * @package WP_Currencies
 */
namespace WP_Softgen_Currency_Rates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Exchange rates.
 *
 * Class that handles currency data in WP Currencies.
 *
 * @since 1.0.0
 */
class Rates {

	/**
	 * Currencies list.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $currencies_list = null;

	/**
	 * Exchange rates source.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $currencies_rates = null;

	/**
	 * Construct.
	 *
	 * @since 1.0.0
	 *//*
	public function __construct() {
		// Note: afaik SSL is supported by OpenExchangeRates on their paid subscription only
		$this->currencies_list  = 'http://openexchangerates.org/api/currencies.json';
		$this->currencies_rates = 'http://openexchangerates.org/api/latest.json?app_id=';
	}
*/
	/**
	 * Make currency data.
	 *
	 * Helper function to return data with currency information, according to currency code.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 *
	 * @return array
	 *//*
	public function make_currency_data() {

		$currencies = array();

		$currency_data = wp_remote_get( $this->currencies_list );
		$currency_data = isset( $currency_data['body'] ) ? (array) json_decode( $currency_data['body'] ) : $currency_data;

		// Check if remote request didn't fail.
		if ( ! $currency_data instanceof \WP_Error ) {

			// Expecting an array with over 100 currencies.
			if ( is_array( $currency_data ) && count( $currency_data ) > 100 ) {

				foreach ( $currency_data as $currency_code => $currency_name ) {

					if ( ! is_string( $currency_code ) || ! is_string( $currency_name ) ) {
						continue;
					}

					$currency_code = strtoupper( substr( sanitize_key( $currency_code ), 0, 3 ) );
					// Defaults.
					$currencies[$currency_code] = array(
						'name'          => sanitize_text_field( $currency_name ),
						'symbol'        => $currency_code,
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.'
					);

				}

			}

		}

		// Format meta for each currency.
		include_once WP_CURRENCIES_INC . 'currencies/currency-data.php';
		$currency_data = wp_currencies_format_currency_data( $currencies );

		return (array) apply_filters( 'wp_currencies_make_currency_data', $currency_data );
	}
*/
	/**
	 * Get currency exchange rates.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array with currency codes for keys and exchange rates for values.
	 * /
	public function get_rates() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'currency_rates';

		$results = $wpdb->get_results(
			"SELECT * FROM $table_name", ARRAY_A
		);

		$rates = array();
		if ( $results && is_array( $results ) ) {
			foreach ( $results as $row ) {
				$rates[strtoupper($row['currency_code'])] = array ('buy' => floatval( $row['buy_price'] ), 'sell' => floatval( $row['sell_price'] ));
			}
		}

		return $rates;
	}*/

    /**
     * Get currencies data.
     *
     * @since 1.0.0
     *
     * @return Object
     */
    public function get_currency_rate($currency) {
        global $wpdb;
        $table = $wpdb->prefix . 'currency_rates';
        $results = $wpdb->get_row("SELECT * FROM {$table} WHERE currency_code='{$currency}'", OBJECT);
        return $results;
    }

	/**
	 * Get currencies data.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array with currency codes for keys and currency information for values.
	 */
	public function get_currencies() {
		global $wpdb;
		$table = $wpdb->prefix . 'currency_rates';

		$results = $wpdb->get_results(
			"SELECT currency FROM {$table} order by order_by asc", ARRAY_A
		);

		$currencies = array();
		if ( $results && is_array( $results ) ) {
			foreach ( $results as $row ) {
				$currencies[$row['currency_code']] = $row;
			}
		}
		return $currencies;
	}

    public function get_currencies_rates() {
        global $wpdb;
        $table = $wpdb->prefix . 'currency_rates';

        $results = $wpdb->get_results(
            "SELECT * FROM {$table} order by order_by asc", ARRAY_A
        );

        $currencies = array();
        if ( $results && is_array( $results ) ) {
            foreach ( $results as $row ) {
                $currencies[$row['currency_code']] = $row;
            }
        }
        return $currencies;
    }

    public function get_currency_rates_history($currency_code, $date) {
        global $wpdb;
        $table = $wpdb->prefix . 'currency_rates_history';

        $sql = "SELECT * FROM {$table} WHERE currency_code='{$currency_code}' AND rate_date >= DATE('{$date}') 
                AND rate_date < DATE(DATE_ADD(DATE('$date'), INTERVAL 1 DAY)) order by rate_date desc";

        $results = $wpdb->get_results($sql, ARRAY_A);

        $ans = new \Answer();
        $ans->items = $results;
        $ans->success = true;
        return $ans;
    }
}
