/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 2018-03-28
 * Time: 20:42
 */

jQuery(function ($) {
    "use strict";

    let currency_to = $("#currency_to");
    let currency_from = $("#currency_from");
    let currency_rates_history_table_tbody = $("#currency_rates_history_table tbody");

    if (!!currency_to) {
        currency_to.val("USD");
    }

    $("#currency_swap").click(function () {
        let temp = currency_from.val();
        currency_from.val(currency_to.val());
        currency_to.val(temp);
    });


    let getExchange = function () {
        let amount = $("#currency_amount").val();
        if (amount === "") {
            $("#currency_convert_result").html("<span id='red'>Please enter something.</span>");
        } else if (isNaN(amount)) {
            $("#currency_convert_result").html("<span id='green'>Please enter a number.</span>");
        } else {
            let data = {
                from: currency_from.val(),
                to: currency_to.val(),
                amount: amount
            };

            $.get("/index.php/wp-json/currency/currency_convert", data)
                .done(function (converted_amount) {
                    $("#currency_convert_result").html(converted_amount[0] +
                            "<span class='grey'> = </span><span class='green'>" + converted_amount[1] + "</span>");
                })
                .fail(function () {
                    // alert( "error" );
                })
                .always(function () {
                    // alert( "finished" );
                });
        }
        return false;
    };

    $("#currency_convert").click(getExchange);
    $("#currency_amount").keyup(function (event) {
        if (event.keyCode === 13) {
            getExchange();
        }
    });


    let getcurrencyRates = function () {
        let cdate = $("#currency_rates_history_date").val();
        let currency = $("#currency_rates_history_currency").val();

        if (cdate === "") {
            currency_rates_history_table_tbody.html("<span id='red'>Please enter something.</span>");
        // } else if (isNaN(amount)) {
        //     $("#currency_rates_history_table").html("<span id='green'>Please enter a number.</span>");
        } else {
            let data = {
                date: cdate,
                currency: currency
            };

            $.get("/index.php/wp-json/currency/rates_history", data)
                .done(function (ans) {
                    if (!ans || ans.success !== true) {
                        return;
                    }

                    let s = "";
                    ans.items.forEach(function (item) {
                        s = s + "<tr><td>" + item.currency_code + "</td>" +
                                "<td>" + item.rate_date.substr(0, 11) + "</td>" +
                                "<td>" + item.rate_date.substr(11) + "</td>" +
                                "<td>" + item.buy_price + "</td>" +
                                "<td>" + item.sell_price + "</td>" +
                                "</tr>";
                    });
                    currency_rates_history_table_tbody.html(s);
                })
                .fail(function () {
                    // alert( "error" );
                })
                .always(function () {
                    // alert( "finished" );
                });
        }
        return false;
    };

    $("#currency_rates_history_get").click(getcurrencyRates);
    $("#currency_rates_history_date").keyup(function (event) {
        if (event.keyCode === 13) {
            getcurrencyRates();
        }
    });

    $(".giro_rate_button").click(function () {
        $(".currency_rates_table .buy_price").show();
        $(".currency_rates_table .sell_price").show();
        $(".currency_rates_table .nbg_rate").hide();
    });

    $(".nbg_rate_button").click(function () {
        $(".currency_rates_table .buy_price").hide();
        $(".currency_rates_table .sell_price").hide();
        $(".currency_rates_table .nbg_rate").show();
    });
});
