define([
    'uiComponent',
    'ko',
    'Magento_Customer/js/customer-data',
    'Yaroslav_RegularCustomer_formSubmitRestrictions',
    'Magento_Customer/js/model/authentication-popup'
], function (Component, ko, customerData, formSubmitRestrictions, authenticationPopup) {
    'use strict';

    return Component.extend({
        defaults: {
            allowForGuests: false,
            template: 'Yaroslav_RegularCustomer/login-button'
        },

        customerMustLogIn: formSubmitRestrictions.customerMustLogIn,
        isLoggedIn: !!customerData.get('personal-discount')().isLoggedIn,

        /**
         * Constructor
         */
        initialize: function () {
            this._super();

            customerData.get('personal-discount').subscribe((personalInfo) => {
                this.isLoggedIn(!!personalInfo.isLoggedIn);
            });
        },

        /**
         * Initialize observables and subscribe to their change if needed
         * @returns {*}
         */
        initObservable: function () {
            this._super();

            this.observe(['isLoggedIn']);

            this.customerMustLogIn = ko.computed(() => {
                return !this.allowForGuests && !this.isLoggedIn();
            });
            formSubmitRestrictions.customerMustLogIn(this.customerMustLogIn());
            this.customerMustLogIn.subscribe((newValue) => {
                formSubmitRestrictions.customerMustLogIn(newValue);
            });

            this.shouldShowLoginButton = ko.computed(() => {
                return this.customerMustLogIn() && !formSubmitRestrictions.requestAlreadySent();
            });

            return this;
        },

        /**
         * Show login popup on button click
         */

        showModal: function () {
            authenticationPopup.showModal();
        }
    });
});
