$(document).ready(function () {
    $('#search-table').keyup(function () {

        // Search text
        var text = $(this).val().toLowerCase();

        // Hide all content class element
        $('.webshelf-table .row').hide();

        // Search 
        $('.webshelf-table .row .title').each(function () {
            if ($(this).text().toLowerCase().indexOf("" + text + "") != -1) {
                $(this).closest('.row').show();
            }
        });

    });
});