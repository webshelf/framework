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
    theme: 'modern',
    height: 500,
    content_css: '/assets/frontend.css',

    // or finally, add your padding directly
    content_style: "body {margin: 20px; background: white;}",

    file_browser_callback : elFinderBrowser,

    plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    image_advtab: true,
});


// is this even used:?
// @todo remove?
tinymce.init({
    branding: false,
    selector: '.page-editor',
    theme: 'modern',
    height: 500,
    content_css: '/assets/frontend.css',

    // or finally, add your padding directly
    content_style: "body {margin: 20px; background: white;}",

    file_browser_callback : elFinderBrowser,

    plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    image_advtab: true,
});