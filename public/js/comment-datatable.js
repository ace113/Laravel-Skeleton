// console.log(params);
$(function () {
    var table = $('#comment-table').DataTable({
        language: {
            emptyTable: "No data available in table",
        },
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: {
            url: dataUrl,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "commentable_type": model,
                "commentable_id": cid,
            }
        },
        columnDefs: [{
            targets: [0, 4],
            className: "text-center",
        }],
        columns: [{
                data: "DT_RowIndex",
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment'
            },
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'model',
                name: 'model'
            },
            {
                data: 'parent',
                name: 'parent'
            },
            {
                data: 'submitted_on',
                name: 'submitted_on'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
    });

    // change status
    $(document).on('click', '.change-status', function () {
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            closeOnConfirm: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: statusUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    }
                }).done(function () {
                    table.draw();
                });
            }
        });
    });

    // delete data item
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: deleteUrl + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).fail(function(data){
                    toastr.error(data.responseJSON.message)
                }).done(function () {
                    table.draw();
                });
            }
        });
    });
});
