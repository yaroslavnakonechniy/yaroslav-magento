define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Yaroslav_RegularCustomer_submitFormAction',
    'Yaroslav_RegularCustomer_formSubmitRestrictions',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, ko, Component, customerData, submitFormAction, formSubmitRestrictions) {
    'use strict';
    return Component.extend({
        defaults: {
            action: '',
            allowForGuests: false,
            isModal: true,
            productId: 0,
            template: 'Yaroslav_RegularCustomer/form'
        },

        customerName: '',
        customerEmail: '',
        customerMessage: '',
        isLoggedIn: !!customerData.get('personal-discount')().isLoggedIn,
        productIds: [],

        /**
         * Constructor
         */
        initialize: function () {
            this._super()

            this.updateFormState(customerData.get('personal-discount')());
            customerData.get('personal-discount').subscribe(this.updateFormState.bind(this));
        },

        /**
         * Initialize observables and subscribe to their change if needed
         * @returns {*}
         */

        initObservable: function () {
            this._super();
            // Watch name, email and message: customer may change them, or they come from the server
            // Watch isLoggedIn and productIds because they come from the server
            this.observe(['customerName', 'customerEmail', 'customerMessage', 'isLoggedIn', 'productIds']);

            this.customerMustLogIn = ko.computed(() => {
                return !this.allowForGuests && !this.isLoggedIn()
            });
            formSubmitRestrictions.customerMustLogIn = this.customerMustLogIn;

            this.formSubmitDeniedMessage = ko.computed(() => {
                    if (this.productIds().includes(this.productId)) {
                        return $.mage.__('Discount request for this product has already been sent');
                    }

                    if (this.customerMustLogIn()) {
                        return $.mage.__('Please, log in to send a request');
                    }

                return '';
            });
            formSubmitRestrictions.formSubmitDeniedMessage = this.formSubmitDeniedMessage;

            return this;
        },

        /**
         * Pre-fill form fields with data, hide fields if needed.
         * @param {Object} personalInfo
         */
        updateFormState: function (personalInfo) {
            if (personalInfo.hasOwnProperty('name')) {
                this.customerName(personalInfo.name);
            }

            if (personalInfo.hasOwnProperty('email')) {
                this.customerEmail(personalInfo.email);
            }

            this.isLoggedIn(personalInfo.isLoggedIn);
        },

        /**
         * Save current for element and initialize modal window
         * @param {Node} element
         */
        initModal: function (element) {
            this.$form = $(element);

            if (this.isModal) {
                this.$modal = this.$form.modal({
                    buttons: []
                });

                $(document).on('ya_roslav_regular_customer_form_open', this.openModal.bind(this));
            }
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            this.$modal.modal('openModal');
        },

        /**
         * Validate form and send request
         */
        sendRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return this.$form.validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let payload = {
                name: this.customerName(),
                email: this.customerEmail(),
                message: this.customerMessage(),
                'product_id': this.productId,
                'form_key': $.mage.cookies.get('form_key'),
                isAjax: 1,
            };

            submitFormAction(this.action, payload)
                .always(() => {
                    if (this.isModal) {
                        this.$modal.modal('closeModal')
                    }

                });
        }
    });

});
