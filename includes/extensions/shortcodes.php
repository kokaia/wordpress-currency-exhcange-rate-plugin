<?php
/**
 * WP Currencies shortcodes
 *
 * @package WP_Currencies\Shortcodes
 */

namespace WP_Softgen_Currency_Rates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Shortcodes.
 *
 * Add WordPress shortcodes for WP Currencies.
 *
 * @since 1.0.0
 */
class Shortcodes {

	/**
	 * Register shortcodes.
	 *
	 * @uses add_shortcode()
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
//		add_shortcode( 'currency_convert', array( $this, 'currency_conversion_shortcode' ) );
//		add_shortcode( 'currency_symbol',  array( $this, 'currency_symbol_shortcode' ) );
		add_shortcode( 'currencies_rates',  array( $this, 'currencies_rates_shortcode' ) );
		add_shortcode( 'currency_rates_history',  array( $this, 'currency_rates_history_shortcode' ) );
	}

	/**
	 * Shortcode callback function to convert value in one currency into another
	 *
	 * @uses convert_currency()
	 *
	 * @since 1.0.0
	 *
	 * @param  array $atts Shortcode attributes.
	 * @return string The resulting converted amount
	 *//*
	public function currency_conversion_shortcode( $atts ) {

		$args = shortcode_atts( array(
			'amount'=> '',
			'from' 	=> '',
			'in' 	=> '',
			'round' => 2,
		), $atts );

		// convert currency
		$conversion = convert_currency( floatval( $args['amount'] ), strtoupper( $args['from'] ), strtoupper( $args['in'] ) );
		// round result
		$rounding = intval( $args['round'] ) >= 0 ? intval( $args['round'] ) : 2;
		$converted_amount = round( $conversion, $rounding );

		return '<span class="currency converted-currency">' . $converted_amount . '</span>';
	}*/

	/**
	 * Shortcode callback function to output a currency symbol.
	 *
	 * @uses get_currency()
	 *
	 * @since 1.0.0
	 *
	 * @param  array  $atts	Shortcode attributes.
	 * @return string HTML entity of the symbol of the specified currency code.
	 *//*
	public function currency_symbol_shortcode( $atts ) {

		$args = shortcode_atts( array(
			'currency' 	=> '',
		), $atts );

		// get currency data
		$currency_data = get_currency( strtoupper( $args['currency'] ) );
		$symbol = $currency_data['symbol'];

		return '<span class"currency currency-symbol">' . $symbol . '</span>';
	}
*/
    /**
     * currency_rates_history shortcode callback function to output a currency rates.
     *
     * @uses get_currencies_rates()
     *
     * @since 1.0.0
     *
     * @return string HTML entity of the symbol of the specified currency code.
     */
    public function currency_rates_history_shortcode( ) {
//        wp_register_style( 'currencies_rates.css', WP_CURRENCY_RATES_ASSERTS . 'currencies_rates.css', array(), WP_CURRENCY_RATES_VERSION );
//        wp_enqueue_style( 'currencies_rates.css');

        wp_register_script( 'currencies_rates.js', WP_CURRENCY_RATES_ASSERTS. 'currencies_rates.js', array('jquery'), WP_CURRENCY_RATES_VERSION );
        wp_enqueue_script( 'currencies_rates.js' );

        $currency_data = get_currencies_rates( );

        $currencies = wp_softgen_currency_rates()->currencies;

        $options = "";
//        $rates = '';
//
//
        foreach ($currency_data as $key => $currency) {
            $cdata = $currencies->get_currency( strtoupper( $currency['currency_code'] ) );
            $options .= "<option value='{$currency['currency_code']}' title='{$cdata['name']}'>{$currency['currency_code']}</option>";
//            $rates .= "<tr><td>{$currency['currency_code']}</td><td>{$currency['buy_price']}</td><td>{$currency['sell_price']}</td></tr>";
        }
   return  "<form class=\"form-inline\">
  <label class=\"exampleSelect1\" for='currency_rates_history_currency'><font face=\"Mtavruli1\">" . __( 'Currency', 'wp_currency_rates' ) . "</font></label>
  <select class=\"form-control\" id='currency_rates_history_currency'><option selected>" . __( 'Select', 'wp_currency_rates' ) . "...</option>{$options}</select>
  &nbsp;&nbsp;
  &nbsp;
  <label for=\"example-date-input\"><font face=\"Mtavruli1\">" . __( 'Date', 'wp_currency_rates' ) . "</font></label>
    <input type='date' class='form-control' id='currency_rates_history_date'>

&nbsp;&nbsp;
&nbsp;&nbsp;

<font face=\"Mtavruli1\"><input class=\"btn btn-warning\" type=\"reset\" value=\"" . __( 'Reset', 'wp_currency_rates' ) . "\"></font>
&nbsp;&nbsp;
&nbsp;&nbsp;

<font face=\"Mtavruli1\">  <input class='btn btn-success' type='button' value='" . __( 'Show', 'wp_currency_rates' ) . "' id='currency_rates_history_get'></font>
</form>
<hr class=\"line-orange-center\">
<div class=\"tbl-header\">
    <table cellpadding='0' cellspacing=\"0\" border=\"0\">
      <thead>
        <tr>
          <th>" . __( 'Currency', 'wp_currency_rates' ) . "</th>
          <th>" . __("Time", 'wp_currency_rates') . "</th>
          <th>" . __("Date", 'wp_currency_rates') . "</th>
          <th>" . __("Buy", 'wp_currency_rates') . "</th>
          <th>" . __("Sell", 'wp_currency_rates') . "</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class='tbl-content' id='currency_rates_history_table'>
    <table cellpadding='0' cellspacing='0' border='0'>
      <tbody>
      </tbody>
    </table>
  </div>";

    }

    private function get_nbg_rate(&$client, $currency){
        $should_update = false;
        try {
            $date1 = new \DateTime("now",  new \DateTimeZone( "Asia/Tbilisi" ));
            $date1->sub(new \DateInterval('PT1H'));
            $last_nbg_update_date = new \DateTime($currency['last_nbg_update_date'], new \DateTimeZone( "Asia/Tbilisi" ));
            $should_update = $date1 > $last_nbg_update_date;
        } catch (\Exception $e) {
            $should_update = true;
        }

        if ($should_update === true) {
            if ($client == false) {
//                $client = new \SoapClient('http://nbg.gov.ge/currency.wsdl', ['proxy_host'=> 'proxy1.mia.gov.ge', 'proxy_port'=>3128]);
                $client = new \SoapClient('http://nbg.gov.ge/currency.wsdl');
            }

            $nbg_price = $client->GetCurrency($currency['currency_code']);

            if (abs($currency['nbg'] - $nbg_price) > 0.000001){
//                exit(print_r($currency, true));
                global $wpdb;
                $wpdb->update(
                    $wpdb->prefix . 'currency_rates',
                    array(
                        'nbg'  => $nbg_price,
                        'last_nbg_update_date' => date_format(new \DateTime("now",  new \DateTimeZone( "Asia/Tbilisi" )), 'Y-m-d H:i:s')
                    ),
                    array('currency_code' => $currency['currency_code']),
                    array('%f', '%s'),
                    array('%s')
                );

//                $wpdb->insert(
//                    $currency_rates_history_table,
//                    array(
//                        'currency_code' => $currency,
//                        'buy_price'     => $buy_price,
//                        'sell_price'    => $sell_price
//                    ),
//                    array('%s', '%f', '%f')
//                );

            }
            return $nbg_price;
        }
        return $currency['nbg'];
    }

    /**
     * Shortcode callback function to output a currency rates.
     *
     * @uses get_currencies_rates()
     *
     * @since 1.0.0
     *
     * @return string HTML entity of the symbol of the specified currency code.
     */

    public function currencies_rates_shortcode( ) {
        wp_register_style( 'currencies_rates.css', WP_CURRENCY_RATES_ASSERTS . 'currencies_rates.css', array(), WP_CURRENCY_RATES_VERSION );
        wp_enqueue_style( 'currencies_rates.css');

        wp_register_script( 'currencies_rates.js', WP_CURRENCY_RATES_ASSERTS. 'currencies_rates.js', array('jquery'), WP_CURRENCY_RATES_VERSION );
        wp_enqueue_script( 'currencies_rates.js' );

        $currency_data = get_currencies_rates( );

        $currencies = wp_softgen_currency_rates()->currencies;

        $cdata = $currencies->get_currency('GEL');
        $options = "<option value='GEL' title='{$cdata['name']}'>GEL</option>";
        $rates = '';
        $client = false;
//        print $client->GetCurrencyDescription('USD').'<br>';
//        print $client->GetCurrency('USD').'<br>';
//        print $client->GetCurrencyRate('USD').'<br>';
//        print $client->GetCurrencyChange('USD').'<br>';
//        print $client->GetDate().'<br>';

        foreach ($currency_data as $key => $currency) {
            $cdata = $currencies->get_currency( strtoupper( $currency['currency_code'] ) );
            $options .= "<option value='{$currency['currency_code']}' title='{$cdata['name']}'>{$currency['currency_code']}</option>";
            $nbg_rate = $this->get_nbg_rate($client, $currency);

            $rates .= "<tr class='{$currency['currency_code']}'>
                         <td class='currency'> {$currency['currency_code']}</td>
                         <td class='buy_price'>{$currency['buy_price']}</td>
                         <td class='sell_price'>{$currency['sell_price']}</td>
                         <td class='nbg_rate'>{$nbg_rate}</td>
                       </tr>";
        }
/*
        <option value='GEL' title='Georgian Lari'>GEL</option>
                    <option value='USD' title='United States Dollar'>USD</option>
                    <option value='EUR' title='Euro'>EUR</option>
                    <option value='GBP' title='British Pound'>GBP</option>
                    <option value='RUB' title='Russian Ruble'>RUB</option>
                    <option value='TRY' title='Turkish Lira'>TRY</option>
                    <option value='AZN' title='Azerbaijani Manat'>AZN</option>
*/
        return "<div class='container-fluid '>
    <section class='row text-center'>
        <div class='border'>
     
            <form onsubmit='return false;'>
                <input type='text' id='currency_amount' placeholder='Enter value' value='1' required>
                <br class='rwd-break'/>
                <select name='currency_from' id='currency_from'>{$options}</select>
                <a class='btn' id='currency_swap'>⇆</a>
                <select name='currency_to' id='currency_to'>{$options}</select>
                <br class='rwd-break'/>
                <button class='btn-group' id='currency_convert'>OK</button>
               
                    <div id='currency_convert_result' class='resulti'></div>
                
                <hr class='line-orange-center'>
                 
                <div class='tbl-header'>
                    <table cellpadding='0' cellspacing='0' border='0' class='currency_rates_table'>
                        <thead>
                        <tr>
                            <th class='currency'>" . __("Currency", 'wp_currency_rates') . "</th>
                            <th class='buy_price'>" . __("Buy", 'wp_currency_rates') . "</th>
                            <th class='sell_price'>" . __("Sell", 'wp_currency_rates') . "</th>
                            <th class='nbg_rate'>" . __("National", 'wp_currency_rates') . "</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class='tbl-content'>
                    <table cellpadding='0' cellspacing='0' border='0' class='currency_rates_table'>
                        <tbody>{$rates}</tbody>
                    </table>
                    <div class='giro_rate_button'>
  <input type='radio' checked name='tab' id='tab1'>
  <label for='tab1'>" . __("Giro", 'wp_currency_rates') . "</label></div>  
         <div class='nbg_rate_button'>
  <input type='radio' name='tab' id='tab2'>
  <label for='tab2'>" . __("National", 'wp_currency_rates') . "</label></div>            
      <div class='type'>
		<p><img src='http://gir.webmakers.ge/wp-content/uploads/2018/04/phone-md13.png' height='38' width='96'></p>
		</div>
                </div>
            </form>
        </div>
    </section>
</div>";
    }
}

new Shortcodes();
