// https://www.tinymce.com/docs/get-started/basic-setup/
window.tinymce = require('tinymce');

// Main controller of the plugin editor files and shit.

function elFinderBrowser (field_name, url, type, win) {
    tinymce.activeEditor.windowManager.open({
        file: '/elfinder/tinymce',// use an absolute path!
        title: 'elFinder 2.0',
        width: 1300,
        height: 600,
        resizable: 'yes'
    }, {
        setUrl: function (url) {
            win.document.getElementById(field_name).value = url;
        }
    });
    return false;
}

tinymce.init({
    branding: false,
    selector: '.editor',

    file_browser_callback : elFinderBrowser,

    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
});

tinymce.init({
    branding: false,
    selector: '.page-editor',
    content_css: '/assets/frontend.css',

    file_browser_callback : elFinderBrowser,

    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
});