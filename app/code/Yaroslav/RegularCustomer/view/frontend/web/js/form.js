define([
    'jquery',
    'Magento_Ui/js/modal/alert'
    // Other dependencies go here
], function ($) {
    'use strict';

    return function (message) {
        // Do the stuff here
        $('<div>').text($.mage.__('Foo Bar Baz')).alert({
            title: $.mage.__(message),
            actions: {
                always: function(){}
            }
        });
    };
});
