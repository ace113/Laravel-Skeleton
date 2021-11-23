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
function closeAlert() {
    setTimeout(() => {
        $('.alert').hide();
    }, 5000);
}
closeAlert();


/**
 * PERMISSION SELELEC ALL / DESELECT ALL
 */
var permissionChecks = document.getElementsByName('permission[]'),
    permissionSelectAll = document.querySelector('.per_select_all'),
    permissionDeselectAll = document.querySelector('.per_deselect_all')

if(permissionChecks.length> 0){
    if(permissionChecks){
        function perSelectAll() {
            for (var checkbox of permissionChecks) {
                //    console.log(checkbox)
                checkbox.setAttribute('checked', true);
                checkbox.parentElement.classList.add('checked')
            }
        }
        
        permissionSelectAll.addEventListener('click', perSelectAll);
        
        function perDeselectAll() {
            for (var checkbox of permissionChecks) {
                //    console.log(checkbox)
                checkbox.removeAttribute('checked', true);
                checkbox.parentElement.classList.remove('checked')
            }
        }
        
        permissionDeselectAll.addEventListener('click', perDeselectAll);
    }
}


