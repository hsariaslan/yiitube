$(function () {
    'use strict';
    $("#uploadFile").change(e => {
        $(e.target).closest("form").trigger("submit");
    });
});