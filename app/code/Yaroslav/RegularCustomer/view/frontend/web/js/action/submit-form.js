define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, alert) {
    'use strict';

    /**
     * @param {String} action
     * @param {Object} payload
     */
    return function (action, payload) {
        return $.ajax({
            url: action,
            data: payload,
            type: 'post',
            dataType: 'json',

            /** @inheritdoc */
            beforeSend: function () {
                $('body').trigger('processStart');
            },

            /**
             * Success means that response from the server was received, but not that the request was saved!
             *
             * @param {Object} response
             */
            success: function (response) {
                alert({
                    title: $.mage.__('Posting your request...'),
                    content: response.message
                });
            },

            /** @inheritdoc */
            error: function () {
                alert({
                    title: $.mage.__('Error'),
                    content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                });
            },

            /** @inheritdoc */
            complete: function () {
                $('body').trigger('processStop');
            }
        });
    };
});
