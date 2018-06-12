import Axios from "axios";

$(document).ready(function () {

    $('[data-type=alert]').click(function(event) {
        event.preventDefault(); 
        
        var confirmed = confirm($(this).attr('data-confirm'));

        if (confirmed) {
            Axios.delete($(this).attr('href')).then(function(response) {
                if (response.data.status = true) {
                    window.location = response.data.redirect;
                    console.log(response.data.redirect);
                } else {
                    alert("Something went wrong.."); 
                }
            });
        }

    });
});