$(document).ready(function () {
    $('#inspectiontable').DataTable({
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
                    "data": "created_at",
                },
                {
                    "data": "action",
                },
            ],
      });
});