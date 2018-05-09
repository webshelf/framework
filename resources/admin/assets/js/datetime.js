
// https://momentjs.com
var moment = require('moment');

// https://www.npmjs.com/package/pc-bootstrap4-datetimepicker
window.datetimepicker = require('pc-bootstrap4-datetimepicker');

$(document).ready(function() {

    // load datetime picker to this class.
    $('.datetimepicker').datetimepicker({
        format : 'DD/MM/YYYY'
    });

    // pre-formate publish date with current time and date.
    $('#publish_date').val(moment().format("DD/MM/YYYY"));

    // default a clear button on the datetimepicker reset.
    $(".btn-clear-form").bind('click', function() {
        var element = $(this).parents(".input-group").children("input");

        if (element.is("#publish_date")) {
            return element.val(moment().format("DD/MM/YYYY"));
        }

        if (element.is("#unpublish_date")) {
            return element.val("");
        }

        return element.val("");

    });
    
});