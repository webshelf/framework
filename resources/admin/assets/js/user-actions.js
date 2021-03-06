import Axios from "axios";
import iziToast from "izitoast";

$(document).ready(function () {

    $('[data-type=deletion]').click(function(event) {
        event.preventDefault();

        let element = $(this);

        var url = $(this).attr('href');
        var clickedConfirm = confirm($(this).attr('data-confirm'));

        // console.log(clickedConfirm, url);

        if (clickedConfirm === true)
        {
            Axios.post(url,{_method: 'delete'})
                .then(function (response) {
                    element.closest('.row').hide();
                    iziToast.success({
                        title: 'OK',
                        message: 'Successfully removed this record!',
                    });
                })
                .catch(function (error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Could not remove this record!',
                    });
                });
        }


        // if (confirmed) {
        //     Axios.delete($(this).attr('href')).then(function(response) {
        //         if (response.data.status == true) {
        //             window.location = response.data.redirect;
        //             console.log(response.data.redirect);
        //         } else {
        //             alert("Something went wrong..");
        //         }
        //     });
        // }

    });
});