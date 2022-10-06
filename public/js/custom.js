$(document).ready(function () {
    $(".alert").delay(2000).slideUp(200, function () {
        $(this).alert('close');
      });
    var inspectiontable = $('#inspectiontable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "inspectiontypedetails",
                "type": "POST",
                'beforeSend': function(request) {
                    request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
                },
            },
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
              ],
            "columns": [
                {
                    "data": "created_at",
                },
                {
                    "data": "sno",
                },
                {
                    "data": "name",
                },
                {
                    "data": "description",
                },
                {
                    "data": "status",
                },
                {
                    "data": "action",
                },
            ],
      });
      inspectiontable.on('click', '.delete', function() {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'inspection-type-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function(data) {
                        inspectiontable.ajax.reload();
                    },
                    error: function(data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    inspectiontable.on('click', '.status', function() {
            element = $(this);
            var userid = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        url: 'inspection-type-status-update',
                        data: { 
                            id: userid
                        },
                        dataType: 'json',
                        success: function(data) {
                            inspectiontable.ajax.reload();
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });
                };
            });
        });
});