/**
 * Created by Mark on 24/08/2016.
 */


$(document).ready(function(){

    new Vue({
        el: '#form',
        methods: {
            refreshPage: function () {
                location.reload(true);
            },
            loadUrl: function (url) {
                window.location.href = url;
            },
            ajaxDelete: function (request, redirect) {
                alert('clicked');
                this.setCSRFToken();
                Vue.http.post(request).then(function(response) {
                    if(response.data.success == true)
                    {
                        window.location.href = redirect;
                    }
                    else
                    {
                        toastr.warning(response.data.message);
                    }
                }, function(response) {
                    toastr.error('Something bad happened, please try again later.' + ' ' + response.status.text);
                });
            },
            setCSRFToken: function(token) {
                Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');
            }
        }
    });

});