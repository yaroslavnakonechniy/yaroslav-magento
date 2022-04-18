define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('Yaroslav.regularCustomer_formOpenButton', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRequestForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('ya_roslav_regular_customer_form_open');
        }
    });

    return $.Yaroslav.regularCustomer_formOpenButton;
});
