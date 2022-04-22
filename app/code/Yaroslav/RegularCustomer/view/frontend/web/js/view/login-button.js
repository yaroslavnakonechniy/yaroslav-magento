define([
    'uiComponent',
    'Yaroslav_RegularCustomer_formSubmitRestrictions',
    'Magento_Customer/js/model/authentication-popup',
    'Yaroslav_RegularCustomer_form'
], function (Component, formSubmitRestrictions, authenticationPopup) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Yaroslav_RegularCustomer/login-button'
        },

        customerMustLogIn: formSubmitRestrictions.customerMustLogIn,

        showModal: function () {
            authenticationPopup.showModal();
        }
    });
});
