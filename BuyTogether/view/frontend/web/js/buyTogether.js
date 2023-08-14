define([
    'jquery',
    'mage/url',
    'Magento_Customer/js/customer-data'
],function(
    $,
    urlBuilder,
    customerData
) {

    let USDollar = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    return function (config) {
        function postCart(product) {
            $.ajax({
                url: urlBuilder.build("ebuytogetherfix/product/addtocart"),
                type: 'POST',
                dataType: 'json',
                data: {
                    productIds: product,
                },
                complete: function () {
                    customerData.invalidate(['cart']);
                    customerData.reload(['cart'], true);
                },
            });
        }

        $(function() {

            $(".choose-product-bt").prop("checked",true);

            $(".choose-product-bt").click(function() {

                let lengthArr = $(".choose-product-bt").length;

                let count = 0;

                let price = Number(config.thisProductPrice);

                for (let i = 0; i < lengthArr; i++) {
                    if ($($(".choose-product-bt")[i]).prop("checked")) {
                        price += Number($($(".choose-product-bt")[i]).attr("data-price-product"));
                        count++;
                    }
                }

                if (count !== lengthArr) {
                    $(".discountPrice").css("display","none");
                    $(".basePrice").css("text-decoration","none");
                    $(".basePrice").html(USDollar.format(price));
                } else {
                    $(".discountPrice").css("display","block");
                    $(".basePrice").css("text-decoration","line-through");
                    $(".basePrice").html(USDollar.format(price));
                }

            });

            $(".correct-sale").click(function() {
                let option = confirm("Are you sure sale this product ?");

                if (!option) return;

                let lengthArr = $(".choose-product-bt").length;

                let product = "";

                let count = 0;

                for (let i = 0; i < lengthArr; i++) {
                    if ($($(".choose-product-bt")[i]).prop("checked")) {
                        product += $($(".choose-product-bt")[i]).attr("data-id-product")+"/";
                        count++;
                    }
                }

                product = product + config.thisProductId;
                postCart(product);
            });
        });
    }
});
