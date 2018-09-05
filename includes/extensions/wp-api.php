<?php
/**
 * WP Currencies API
 *
 * Support for WordPress JSON REST API.
 *
 * @package WP_Softgen_Currency_Rates\API
 */

namespace WP_Softgen_Currency_Rates;

use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WP Currencies API class.
 *
 * Extends WP API with currencies routes.
 *
 * @since 1.0.0
 */
class API {

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var API
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return API A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Register JSON API routes.
	 * Provides two endpoints for the API `/currencies/` and `/currencies/rates/`.
	 *
	 * @since 1.0.0
	 *
	 */
	public function register_routes( ) {

        register_rest_route( 'currency',
            '/',
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => 'get_currencies',
            )
        );

        register_rest_route( 'currency',
            'rates',
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => 'get_currencies_rates',
            )
        );

        register_rest_route( 'currency',
            'update_rate', //. '/(?P<currency>[\w]+)'. '&(P<buy_price>[\d]+)'. '&(P<sell_price>[\d]+)',
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array($this, 'update_currency_rate'),
                'args' => array(
                    'currency' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'string',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'buy_price' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'float',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'sell_price' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'float',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'checksum' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'string',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    )
                )
            )
        );

        register_rest_route( 'currency',
            'rates_history', //. '/(?P<currency>[\w]+)'. '&(P<buy_price>[\d]+)'. '&(P<sell_price>[\d]+)',
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array($this, 'get_currency_rates_history'),
                'args' => array(
                    'currency' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'string',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'date' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'float',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => false,
                    )
                )
            )
        );

        register_rest_route( 'currency',
            'currency_convert', //. '/(?P<currency>[\w]+)'. '&(P<buy_price>[\d]+)'. '&(P<sell_price>[\d]+)',
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array($this, 'currency_convert'),
                'args' => array(
                    'from' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'string',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'to' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'string',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'amount' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'float',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => true,
                    ),
                    'no_format' => array(
                        'description'       => esc_html__( 'This is the argument our endpoint returns.', 'wp_softgen_currency_rates' ),
                        'type'              => 'boolean',
//                    'validate_callback' => 'prefix_validate_my_arg',
//                    'sanitize_callback' => 'prefix_sanitize_my_arg',
                        'required'          => false,
                    )
                )
            )
        );
	}

    /**
     * Get currency data API callback function.
     *
     * @since 1.0.0
     *
     * @return array Currencies data
     */
    public function get_currencies() {
        return get_currencies();
    }

    /**
     * Get currency data API callback function.
     *
     * @since 1.0.0
     *
     * @return array Currencies data
     */
    public function get_currencies_rates() {
        return get_currencies_rates();
    }

    /**
     * Get currency rates history API callback function.
     *
     * @since 1.0.0
     *
     * @param  WP_REST_Request $request
     *
     * @return array Currencies data
     */
    public function get_currency_rates_history($request) {
        $params = $request->get_params();
        $currency   = strtoupper($params['currency']);
        $date  = $params['date'];

        if (!isset($date) || $date == '') {
            $from_date = '2018-03-20';
        }

        return get_currency_rates_history($currency, $date);
    }

	/**
	 * Get currency rates API callback function
	 *
	 * @since 1.0.0
	 *
	 * @param  WP_REST_Request $request
	 * @return string OK if updated.
	 */
	public function update_currency_rate( $request ) {
        global $wpdb;
	    $params = $request->get_params();
        $currency   = strtoupper($params['currency']);
        $buy_price  = floatval($params['buy_price']);
        $sell_price = floatval($params['sell_price']);
	    $checksum   = strtoupper($params['checksum']);
        $checkString = '!@#SoftGen$%^'.$currency.$buy_price;
	    if ((abs($buy_price - round($buy_price)) < 0.0001)) {
            $checkString = $checkString.'.0';
        }
        $checkString = $checkString.$sell_price;
        if ((abs($sell_price - round($sell_price)) < 0.0001)) {
            $checkString = $checkString.'.0';
        }

	    if (strtoupper(sha1($checkString)) !== $checksum) {
//            return  sha1('!@#SoftGen$%^'.$currency.$buy_price.$sell_price);
            return  'ERROR';
        }
        $currency_table = $wpdb->prefix . 'currency_rates';
        $currency_rates_history_table = $wpdb->prefix . 'currency_rates_history';

        $old = $wpdb->get_row( "SELECT * FROM {$currency_table} WHERE currency_code = '{$currency}'", OBJECT );

        $should_insert_history = false;
        if (count($old) == 0) {
            $should_insert_history = true;
            $wpdb->insert(
                $currency_table,
                array(
                    'currency_code' => $currency,
                    'buy_price'     => $buy_price,
                    'sell_price'    => $sell_price
                ),
                array('%s', '%f', '%f')
            );
        } else {
            if (abs($buy_price - $old->buy_price) + abs($sell_price - $old->sell_price) > 0.000001) {
                $wpdb->update(
                    $currency_table,
                    array(
                        'buy_price'  => $buy_price,
                        'sell_price' => $sell_price
                    ),
                    array('currency_code' => $currency),
                    array('%f', '%f'),
                    array('%s')
                );
                $should_insert_history = true;
            }
        }

        if ($should_insert_history=== true) {
            $wpdb->insert(
                $currency_rates_history_table,
                array(
                    'currency_code' => $currency,
                    'buy_price'     => $buy_price,
                    'nbg'     => $old->nbg,
                    'sell_price'    => $sell_price
                ),
                array('%s', '%f', '%f')
            );
        }

		return  'OK';
	}

    /**
     * Get currency data API callback function.
     *
     * @since 1.0.0
     * @param  WP_REST_Request $request
     *
     * @return array Currencies data
     */
    public function currency_convert($request) {
        $params = $request->get_params();
        $from_currency   = strtoupper($params['from']);
        $to_currency  = strtoupper($params['to']);
        $amount = floatval($params['amount']);
        $no_format = boolval($params['no_format']);
        if ($no_format === true){
            return convert_currency($from_currency, $to_currency, $amount);
        }
        return [format_currency($amount, $from_currency), format_currency(convert_currency($from_currency, $to_currency, $amount), $to_currency)];
    }
}
