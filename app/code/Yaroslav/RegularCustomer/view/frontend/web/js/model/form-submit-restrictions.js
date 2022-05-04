define([
    'ko'
], function (ko) {
    'use strict';

    let formSubmitDeniedRestrictions = {
        customerMustLogIn: ko.observable(false),
        requestAlreadySent: ko.observable(false)
    };

    // Can't use "this" here. Probably this is because we're not in the component context?
    formSubmitDeniedRestrictions.submitDenied = ko.computed(function () {
        return formSubmitDeniedRestrictions.customerMustLogIn() || formSubmitDeniedRestrictions.requestAlreadySent();
    });

    return formSubmitDeniedRestrictions;
});
