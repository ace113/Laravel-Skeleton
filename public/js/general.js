$('.summernote').summernote({
    toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['view', ['fullscreen', 'codeview']],
    ],
    tabsize: 2,
    height: 100,
});

// auto close alert after 5 secs
function closeAlert(){
    setTimeout(() => {
        $('.alert').hide();
    }, 5000);
}
closeAlert();