define([
    'ko'
], function (ko) {
    'use strict';

    return {
        customerMustLogIn: ko.observable(), // initialized in DVCampus_PersonalDiscount_form::initObservable()
        formSubmitDeniedMessage: ko.observable() // initialized in DVCampus_PersonalDiscount_form::initObservable()
    };
});
