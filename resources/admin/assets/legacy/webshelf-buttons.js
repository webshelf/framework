$(document).ready(function () {

    $("#btn-delete").click(function () {

        var request = $(this).data("request");
        var redirect = $(this).data("redirect");

        $.post(request, {'type':'delete', '_token': $('meta[name="csrf-token"]').attr('content')})

        .done(function(response)
        {
            if(response.status == true)
                return window.location.href = redirect;

            if(response.notify == true)
                return toastr.warning(response.message);
        })

        .fail(function(response)
        {
            return toastr.warning(response.message);
        });

    });


    $("#btn-refresh").click(function() {

        return location.reload(true);

    });

    $("#btn-cancel").click(function() {

        var redirect = $(this).data("redirect");

        return window.location.href = redirect;

    });

});