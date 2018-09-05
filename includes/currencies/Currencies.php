<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 2018-03-28
 * Time: 21:33
 */

namespace WP_Softgen_Currency_Rates;

class Currency
{

}

class Currencies
{
    var $currencies;

    function __construct()
    {
        $this->currencies=[];
//  "AED": "United Arab Emirates Dirham",
//  "AFN": "Afghan Afghani",
//  "ALL": "Albanian Lek",
//  "AMD": "Armenian Dram",
//  "ANG": "Netherlands Antillean Guilder",
//  "AOA": "Angolan Kwanza",
//  "ARS": "Argentine Peso",
        $this->currencies["AUD"] = array(
        'name'          => "Australian Dollar",
        'symbol'        => 'A&#36;',
        'position'      => 'after',
        'decimals'      => 2,
        'thousands_sep' => ',',
        'decimals_sep'  => '.',
        'correction'    => 1,
    );

//  "AWG": "Aruban Florin",
//  "AZN": "Azerbaijani Manat",
//  "BAM": "Bosnia-Herzegovina Convertible Mark",
//  "BBD": "Barbadian Dollar",
//  "BDT": "Bangladeshi Taka",
//  "BGN": "Bulgarian Lev",
//  "BHD": "Bahraini Dinar",
//  "BIF": "Burundian Franc",
//  "BMD": "Bermudan Dollar",
        $this->currencies["BND"]=array(
            'name'          => "Brunei Dollar",
            'symbol'        => 'B&#36;',
            'position'      => 'before',
            'decimals'      => 2,
            'thousands_sep' => ',',
            'decimals_sep'  => '.',
        );
//  "BOB": "Bolivian Boliviano",
        $this->currencies["BRL"]= array(
            'name'          => "Brazilian Real",
            'symbol'        => 'R&#36;',
            'position'      => 'after',
            'decimals'      => 2,
            'thousands_sep' => '&nbsp;',
            'decimals_sep'  => '.',
        );
//  "BSD": "Bahamian Dollar",
//  "BTC": "Bitcoin",
//  "BTN": "Bhutanese Ngultrum",
//  "BWP": "Botswanan Pula",
//  "BYN": "Belarusian Ruble",
//  "BZD": "Belize Dollar",
        $this->currencies["CAD"] = array(
            'name'          => "Canadian Dollar",
            'symbol'        => 'C&#36;',
            'position'      => 'after',
            'decimals'      => 3,
            'thousands_sep' => '&nbsp;',
            'decimals_sep'  => ',',
        );
//  "CDF": "Congolese Franc",
//  "CHF": "Swiss Franc",
//  "CLF": "Chilean Unit of Account (UF)",
//  "CLP": "Chilean Peso",
//  "CNH": "Chinese Yuan (Offshore)",
//  "CNY": "Chinese Yuan",
//  "COP": "Colombian Peso",
//  "CRC": "Costa Rican Colón",
//  "CUC": "Cuban Convertible Peso",
//  "CUP": "Cuban Peso",
//  "CVE": "Cape Verdean Escudo",
//  "CZK": "Czech Republic Koruna",
//  "DJF": "Djiboutian Franc",
//  "DKK": "Danish Krone",
//  "DOP": "Dominican Peso",
//  "DZD": "Algerian Dinar",
//  "EGP": "Egyptian Pound",
//  "ERN": "Eritrean Nakfa",
//  "ETB": "Ethiopian Birr",
        $this->currencies["EUR"] = array(
            'name'          => "Euro",
            'symbol'        => '&#8364;',
            'position'      => 'before',
            'decimals'      => 2,
            'thousands_sep' => '.',
            'decimals_sep'  => ',',
        );
//  "FJD": "Fijian Dollar",
//  "FKP": "Falkland Islands Pound",
        $this->currencies["GBP"] = array(
            'name'          => "British Pound Sterling",
            'symbol'        => '&#163;',
            'position'      => 'after',
            'decimals'      => 2,
            'thousands_sep' => ',',
            'decimals_sep'  => '.',
        );
//  "":
        $this->currencies["GEL"] = array(
            'name'          => "Georgian Lari",
            'symbol'        => '&#8382;',
            'position'      => 'after',
            'decimals'      => 2,
            'thousands_sep' => ',',
            'decimals_sep'  => '.',
        );
//  "GGP": "Guernsey Pound",
//  "GHS": "Ghanaian Cedi",
//  "GIP": "Gibraltar Pound",
//  "GMD": "Gambian Dalasi",
//  "GNF": "Guinean Franc",
//  "GTQ": "Guatemalan Quetzal",
//  "GYD": "Guyanaese Dollar",
//  "HKD": "Hong Kong Dollar",
//  "HNL": "Honduran Lempira",
//  "HRK": "Croatian Kuna",
//  "HTG": "Haitian Gourde",
//  "HUF": "Hungarian Forint",
//  "IDR": "Indonesian Rupiah",
//  "ILS": "Israeli New Sheqel",
//  "IMP": "Manx pound",
//  "INR": "Indian Rupee",
//  "IQD": "Iraqi Dinar",
//  "IRR": "Iranian Rial",
//  "ISK": "Icelandic Króna",
//  "JEP": "Jersey Pound",
//  "JMD": "Jamaican Dollar",
//  "JOD": "Jordanian Dinar",
//  "JPY": "Japanese Yen",
//  "KES": "Kenyan Shilling",
//  "KGS": "Kyrgystani Som",
//  "KHR": "Cambodian Riel",
//  "KMF": "Comorian Franc",
//  "KPW": "North Korean Won",
//  "KRW": "South Korean Won",
//  "KWD": "Kuwaiti Dinar",
//  "KYD": "Cayman Islands Dollar",
//  "KZT": "Kazakhstani Tenge",
//  "LAK": "Laotian Kip",
//  "LBP": "Lebanese Pound",
//  "LKR": "Sri Lankan Rupee",
//  "LRD": "Liberian Dollar",
//  "LSL": "Lesotho Loti",
//  "LYD": "Libyan Dinar",
//  "MAD": "Moroccan Dirham",
//  "MDL": "Moldovan Leu",
//  "MGA": "Malagasy Ariary",
//  "MKD": "Macedonian Denar",
//  "MMK": "Myanma Kyat",
//  "MNT": "Mongolian Tugrik",
//  "MOP": "Macanese Pataca",
//  "MRO": "Mauritanian Ouguiya (pre-2018)",
//  "MRU": "Mauritanian Ouguiya",
//  "MUR": "Mauritian Rupee",
//  "MVR": "Maldivian Rufiyaa",
//  "MWK": "Malawian Kwacha",
//  "MXN": "Mexican Peso",
//  "MYR": "Malaysian Ringgit",
//  "MZN": "Mozambican Metical",
//  "NAD": "Namibian Dollar",
//  "NGN": "Nigerian Naira",
//  "NIO": "Nicaraguan Córdoba",
//  "NOK": "Norwegian Krone",
//  "NPR": "Nepalese Rupee",
//  "NZD": "New Zealand Dollar",
//  "OMR": "Omani Rial",
//  "PAB": "Panamanian Balboa",
//  "PEN": "Peruvian Nuevo Sol",
//  "PGK": "Papua New Guinean Kina",
//  "PHP": "Philippine Peso",
//  "PKR": "Pakistani Rupee",
//  "PLN": "Polish Zloty",
//  "PYG": "Paraguayan Guarani",
//  "QAR": "Qatari Rial",
//  "RON": "Romanian Leu",
//  "RSD": "Serbian Dinar",
        $this->currencies['RUB'] = array(
            'name'          => "Russian Ruble",
            'symbol'        => '&#8381;',
            'position'      => 'after',
            'decimals'      => 2,
            'thousands_sep' => '.',
            'decimals_sep'  => ',',
            'correction'    => 0.01,
        );
//  "RWF": "Rwandan Franc",
//  "SAR": "Saudi Riyal",
//  "SBD": "Solomon Islands Dollar",
//  "SCR": "Seychellois Rupee",
//  "SDG": "Sudanese Pound",
//  "SEK": "Swedish Krona",
//  "SGD": "Singapore Dollar",
//  "SHP": "Saint Helena Pound",
//  "SLL": "Sierra Leonean Leone",
//  "SOS": "Somali Shilling",
//  "SRD": "Surinamese Dollar",
//  "SSP": "South Sudanese Pound",
//  "STD": "São Tomé and Príncipe Dobra (pre-2018)",
//  "STN": "São Tomé and Príncipe Dobra",
//  "SVC": "Salvadoran Colón",
//  "SYP": "Syrian Pound",
//  "SZL": "Swazi Lilangeni",
//  "THB": "Thai Baht",
//  "TJS": "Tajikistani Somoni",
//  "TMT": "Turkmenistani Manat",
//  "TND": "Tunisian Dinar",
//  "TOP": "Tongan Pa'anga",
        $this->currencies['TRY'] = array(
            'name'          => "Turkish Lira",
            'symbol'        => '&#8378;',
            'position'      => 'after',
            'decimals'      => 2,
            'thousands_sep' => ',',
            'decimals_sep'  => '.',
        );
//  "TTD": "Trinidad and Tobago Dollar",
//  "TWD": "New Taiwan Dollar",
//  "TZS": "Tanzanian Shilling",
//  "UAH": "Ukrainian Hryvnia",
//  "UGX": "Ugandan Shilling",
        $this->currencies['USD'] = array(
            'name'          => 'United States Dollar',
            'symbol'        => '&#36;',
            'position'      => 'before',
            'decimals'      => 2,
            'thousands_sep' => ',',
            'decimals_sep'  => '.',
        );
//  "UYU": "Uruguayan Peso",
//  "UZS": "Uzbekistan Som",
//  "VEF": "Venezuelan Bolívar Fuerte",
//  "VND": "Vietnamese Dong",
//  "VUV": "Vanuatu Vatu",
//  "WST": "Samoan Tala",
//  "XAF": "CFA Franc BEAC",
//  "XAG": "Silver Ounce",
//  "XAU": "Gold Ounce",
//  "XCD": "East Caribbean Dollar",
//  "XDR": "Special Drawing Rights",
//  "XOF": "CFA Franc BCEAO",
//  "XPD": "Palladium Ounce",
//  "XPF": "CFP Franc",
//  "XPT": "Platinum Ounce",
//  "YER": "Yemeni Rial",
//  "ZAR": "South African Rand",
//  "ZMW": "Zambian Kwacha",
//  "ZWL": "Zimbabwean Dollar"

    }

    public function get_currency($currency){
        if (array_key_exists($currency, $this->currencies)) {
            return $this->currencies[$currency];
        }
        return array(
            'name'          => $currency,
            'symbol'        => $currency,
            'position'      => 'before',
            'decimals'      => 2,
            'thousands_sep' => ',',
            'decimals_sep'  => '.',
        );
    }
}

/*

			} elseif ( $currency_code == 'BTC' || $currency_code == 'XBT') {

				// Bitcoin
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => $currency_data['symbol'],
					'position'      => 'before',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'CHF' ) {

				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'SFr.',
					'position'      => 'after',
					'decimals'      => 3,
					'thousands_sep' => '&nbsp;',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'CNY' ) {

				// Chinese Renmimbi (Yuan)
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#165',
					'position'      => 'before',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'DKK' ) {

				// Danish Crown
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'kr.',
					'position'      => 'after',
					'decimals'      => 3,
					'thousands_sep' => '&nbsp;',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'JPY' ) {

				// Japanese Yen
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#165;',
					'position'      => 'after',
					'decimals'      => 0,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'LAK' ) {

				// Laos Kip
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#8365;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'HKD' ) {

				// Hong Kong Dollar
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'HK&#36;',
					'position'      => 'before',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'IDR' ) {

				// Indonesian Rupee
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#8377;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'MMK' ) {

				// Burmese Kyat
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'Ks',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'MYR' ) {

				// Malaysian Ringgit
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'RM',
					'position'      => 'before',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'MXN' ) {

				// Mexican Peso
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'Mex#36;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => '&nbsp;',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'NZD' ) {

				// New Zealand Dollar
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'NZ&#36;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'NOK' ) {

				// Norwegian Crown
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'kr',
					'position'      => 'after',
					'decimals'      => 3,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'PLN' ) {

				// Polish złoty
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'z&#322;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'PHP' ) {

				// Philippines Peso
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#8369;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'RON' ) {

				// Romanian Leu
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'Lei',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'SAR' ) {

				// Saudi Ryal
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'SR',
					'position'      => 'after',
					'decimals'      => 3,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'SGD' ) {

				// Singapore Dollar
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'S&#36;',
					'position'      => 'before',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'SEK' ) {

				// Swedish Crown
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'kr',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => '.',
					'decimals_sep'  => ',',
				);

			} elseif ( $currency_code == 'THB' ) {

				// Thai Baht
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#3647;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'TWD' ) {

				// Taiwan New Dollar
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => 'NT&#36;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'VND' ) {

				// Vietnamese Dong
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#8363;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} elseif ( $currency_code == 'WON' ) {

				// Korean Won
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => '&#8361;',
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			} else {

				// All others
				$data[$currency_code] = array(
					'name'          => $currency_data['name'],
					'symbol'        => $currency_data['symbol'],
					'position'      => 'after',
					'decimals'      => 2,
					'thousands_sep' => ',',
					'decimals_sep'  => '.',
				);

			}

 */
