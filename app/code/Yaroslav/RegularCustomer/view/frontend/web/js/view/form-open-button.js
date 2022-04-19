define([
    'jquery',
    'uiComponent',
    'Yaroslav_RegularCustomer_formSubmitRestrictions'
], function ($, Component, formSubmitRestrictions) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Yaroslav_RegularCustomer/form-open-button'
        },

        formSubmitIsRestricted: formSubmitRestrictions.formSubmitDeniedMessage,

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('ya_roslav_regular_customer_form_open');
        }
    });
});
