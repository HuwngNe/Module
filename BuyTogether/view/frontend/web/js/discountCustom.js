define(
    [
        'uiComponent',
        'jquery',
        'ko',
        'Magento_Checkout/js/model/totals',
        'Magento_Checkout/js/model/quote',
        'jquery/jquery.cookie',
        'mage/translate'
    ],
    function(
        Component,
        $,
        ko,
        totals,
        quote
    ) {
        'use strict';

        let USDollar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        return Component.extend({
            defaults: {
                template: 'Ecommage_BuyTogether/customdiscount',
                customdiscount: ko.observable($.mage.__("Discount"))
            },

            initialize: function () {
                this._super();
            },

            isDisplayedCustomdiscountTotal: function () {
                let price = totals.totals()['subtotal'] - totals.getSegment('grand_total').value + totals.totals()['shipping_amount'];
                return price > 0;
            },

            getCustomdiscountTotal: function () {
                let price = totals.totals()['subtotal'] - totals.getSegment('grand_total').value + totals.totals()['shipping_amount'];
                return "-"+USDollar.format(price);
            },

        });
    }
);
