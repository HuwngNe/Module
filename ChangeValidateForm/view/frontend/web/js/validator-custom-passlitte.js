define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function($){
    $.validator.addMethod(
        'validate-mycustom-password', function (value) {
            return (value.length >= 8);
        }, $.mage.__('Minimum 8 characters'));
});
