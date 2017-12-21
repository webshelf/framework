// https://www.tinymce.com/docs/get-started/basic-setup/
window.tinymce = require('tinymce');

// Main controller of the plugin editor files and shit.

tinymce.init({

    branding: false,
    selector: '.editor',

    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
});