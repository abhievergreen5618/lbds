$(document).ready(function () {
    $(".alert").not('.cancelrequest').not('.reportmail').delay(8000).slideUp(200, function () {
        $(this).alert('close');
    });
    //employee-list with the DataTables
    var employeetable = $('#employeetable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "employee-details",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [
            // {
            //     "data": "created_at",
            // },
            // {
            //     "data": "id",
            // },
            {
                "data": "name",
            },
            {
                "data": "email",
            },
            {
                "data": "company_phonenumber",
            },
            // {
            //     "data": "company_address",
            // },
            {
                "data": "city",
            },
            {
                "data": "state",
            },
            {
                "data": "zip_code",
            },
            {
                "data": "action",
            },

        ],
    });

    //employee-destroy
    employeetable.on('click', '.delete', function () {
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
                    url: 'employee-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        employeetable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    var inspectiontable = $('#inspectiontable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "inspectiontypedetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all"},
        ],
        "order": [[1, 'asc']],
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
    var sendinvoicetable = $('#sendinvoicetable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "sendinvoicedetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
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
    inspectiontable.on('click', '.hide', function () {
        var userid = $(this).attr('data-id');
        var inspectiontitle = "Disable Inspection (" + $(this).attr('data-inspectionname') + ")";
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: 'inspectiontypedisablelist',
            data: {
                id: userid
            },
            dataType: 'json',
            success: function (data) {
                $("#roles").html(data.role).trigger("change");
                $("#roles").attr("data-id", userid);
                $("#users").html(data.user).trigger("change");
                $("#users").attr("data-id", userid);
                $("#modal-overlay .modal-title").html(inspectiontitle);
                $("#modal-overlay").modal("show");
                $("#modal-overlay").find(".overlay").hide();
            },
            error: function (data) {
                // console.log(data);
            }
        });
    });
    inspectiontable.on('click', '.delete', function () {
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
                    success: function (data) {
                        inspectiontable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    inspectiontable.on('click', '.status', function () {
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
                    success: function (data) {
                        inspectiontable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    sendinvoicetable.on('click', '.delete', function () {
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
                    url: 'send-invoice-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        sendinvoicetable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    sendinvoicetable.on('click', '.status', function () {
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
                    url: 'send-invoice-status-update',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        sendinvoicetable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });

    var inspectortable = $('#inspectortable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "inspectortabledetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "company_name",
        },
        {
            "data": "name",
        },
        {
            "data": "color_code",
        },
        {
            "data": "mobile_number",
        },
        {
            "data": "email",
        },
        {
            "data": "status",
        },
        {
            "data": "license_number",
        },
        {
            "data": "area_coverage",
        },
        {
            "data": "profile",
        },
        {
            "data": "action",
        },

        ],
    });

    inspectortable.on('click', '.status', function () {
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
                    url: 'inspector-status-update',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        inspectortable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });

    inspectortable.on('click', '.delete', function () {
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
                    url: 'inspector-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        inspectortable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });

    // Nav sidebar
    // $('nav .nav-item').click(function (e) {
    //     $("li.menu-open").not($(this)).removeClass('menu-is-opening menu-open');
    //     $(".nav-treeview").not($(this).find(".nav-treeview")).css('display', 'none');
    //     $(this).addClass("menu-is-opening menu-open");
    //     $(this).find(".nav-treeview").css('display', 'block');
    // });


    var usertable = $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "usertableedetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
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
                "data": "email",
            },
            {
                "data": "status",
            },
            {
                "data": "action",
            },
        ],
    });


    usertable.on('click', '.delete', function () {
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
                    url: 'inspector-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        usertable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });

    usertable.on('click', '.status', function () {
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
                    url: 'inspector-status-update',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        usertable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });


    $(".preview,.pdfview").mouseenter(function () {
        $(this).find(".image-overlay").show();
    });
    $(".preview,.pdfview").mouseleave(function () {
        $(this).find(".image-overlay").hide();
    });

    //agency fetch all messagesList
    var agencyMessages = $('#agencyMessages').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "agency-messagesdetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "name",
        },
        {
            "data": "email",
        },
        {
            "data": "seen",
        },
        {
            "data": "message",
        }

        ],
    });


    //inspector fetch all messagesList
    var inspectorMessages = $('#inspectorMessages').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "inspector-messagesdetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "name",
        },
        {
            "data": "email",
        },
        {
            "data": "seen",
        },
        {
            "data": "message",
        }

        ],
    });
    $("#refreshBtn").click(function () {
        location.reload();
    });

    var myselect = $('#agency').select2({
        placeholder: "Select",
    });


    //agency-module
    var agencytable = $('#agencytable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "agency-details",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "company_name",
        },
        {
            "data": "name",
        },
        {
            "data": "email",
        },
        {
            "data": "company_address",
        },
        {
            "data": "direct_number",
        },
        {
            "data": "company_phonenumber",
        },
        {
            "data": "zip_code",
        },
        {
            "data": "status",
        },
        {
            "data": "profile",
        },
        {
            "data": "action",
        },
        ],
    });


    agencytable.on('click', '.delete', function () {
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
                    url: 'agency-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        agencytable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });

    agencytable.on('click', '.status', function () {
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
                    url: 'inspector-status-update',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        agencytable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });

    var agencyApprovaltable = $('#agencyApprovaltable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "agency-list/details",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "company_name",
        },
        {
            "data": "name",
        },
        {
            "data": "email",
        },
        {
            "data": "zip_code",
        },
        {
            "data": "approved",
        },
        ],
    });


    agencyApprovaltable.on('change', '.approved', function () {
        element = $(this);
        var userid = $(this).find(':selected').attr('data-id');
        var status = $(this).find(':selected').val();

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
                    url: 'agency-approval/status/update',
                    data: {
                        id: userid,
                        "status": status,
                    },
                    dataType: 'json',
                    success: function (data) {
                        agencyApprovaltable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });



    var agencydisapprovedtable = $('#agencydisapprovedtable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "details",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "company_name",
        },
        {
            "data": "name",
        },
        {
            "data": "email",
        },
        {
            "data": "zip_code",
        },
        {
            "data": "approved",
        },
        ],
    });


    agencydisapprovedtable.on('change', '.approved', function () {
        element = $(this);
        var userid = $(this).find(':selected').attr('data-id');
        var status = $(this).find(':selected').val();

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
                    url: 'agency-approval/status/update',
                    data: {
                        id: userid,
                        "status": status,
                    },
                    dataType: 'json',
                    success: function (data) {
                        agencydisapprovedtable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });


    var userstable = $('#userstable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "users-details",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "sno",
        },
        {
            "data": "name",
        },
        {
            "data": "email",
        },
        {
            "data": "roles",
        },
        {
            "data": "action",
        },
        ],
    });

    userstable.on('click', '.delete', function () {
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
                    url: 'user-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        userstable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });



    var rolestable = $('#rolestable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "roles-details",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ],
        "columns": [{
            "data": "sno",
        },
        {
            "data": "name",
        },
        {
            "data": "action",
        },
        ],
    });

    rolestable.on('click', '.delete', function () {
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
                    url: 'role-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        rolestable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
});



// new dropzone code

Dropzone.autoDiscover = false;
$(document).ready(function () {
    var myagencyfiles = new $("#agencyfiles").dropzone({
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: true,
        url: "fileuploadrequest",
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        maxFilesize: 500,
        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.docx",
        removedfile: function (file) {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode
                .removeChild(
                    file.previewElement) : void 0;
        },
    });
    var myreportfiles = new $("#reportfiles").dropzone({
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: true,
        url: "fileuploadrequest",
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        maxFilesize: 500,
        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.docx",
        removedfile: function (file) {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode
                .removeChild(
                    file.previewElement) : void 0;
        },
    });


    $('#submit-btn').click(function () {
        if ($('#requestform').valid()) {
            if (myreportfiles.length != 0) {
                var myagencyfilesnew = myagencyfiles.get(0).dropzone;
                var myreportfilesnew = myreportfiles.get(0).dropzone;
                if (myagencyfilesnew.files.length == 0 && myreportfilesnew.files.length == 0) {
                    requestformsubmit();
                }
                else if (myagencyfilesnew.files.length != 0 && myreportfilesnew.files.length == 0) {
                    myagencyfilesnew.on('sending', function (file, xhr, formData) {
                        formData.append('type', $(myagencyfiles).attr("id"));
                    });
                    myagencyfilesnew.processQueue();
                    myagencyfilesnew.on("queuecomplete", function () {
                        $('.dz-remove').remove();
                        requestformsubmit();
                    });
                }
                else if (myagencyfilesnew.files.length == 0 && myreportfilesnew.files.length != 0) {
                    myreportfilesnew.on('sending', function (file, xhr, formData) {
                        formData.append('type', $(myreportfiles).attr("id"));
                    });
                    myreportfilesnew.processQueue();
                    myreportfilesnew.on("queuecomplete", function () {
                        $('.dz-remove').remove();
                        requestformsubmit();
                    });
                }
                else {
                    var count = 0;
                    myagencyfilesnew.on('sending', function (file, xhr, formData) {
                        formData.append('type', $(myagencyfiles).attr("id"));
                    });
                    myreportfilesnew.on('sending', function (file, xhr, formData) {
                        formData.append('type', $(myreportfiles).attr("id"));
                    });
                    myagencyfilesnew.processQueue();
                    myreportfilesnew.processQueue();
                    myagencyfilesnew.on("queuecomplete", function () {
                        count++;
                        $('.dz-remove').remove();
                        if (count == 2) {
                            requestformsubmit();
                        }
                    });
                    myreportfilesnew.on("queuecomplete", function () {
                        count++;
                        $('.dz-remove').remove();
                        if (count == 2) {
                            requestformsubmit();
                        }
                    });
                }
            }
            else {
                var myagencyfilesnew = myagencyfiles.get(0).dropzone;
                if (myagencyfilesnew.files.length == 0) {
                    requestformsubmit();
                }
                else {
                    myagencyfilesnew.on('sending', function (file, xhr, formData) {
                        formData.append('type', $(myagencyfiles).attr("id"));
                    });
                    myagencyfilesnew.processQueue();
                    myagencyfilesnew.on("queuecomplete", function () {
                        $('.dz-remove').remove();
                        requestformsubmit();
                    });
                }
            }
            return false;
        }
    });


    $('.uploadfiles').click(function () {
        $(this).attr("disabled","true");
        var id = $(this).attr("data-id");
        var newdropzone = $(this).parent().parent().find('.dropzone');
        if ($(newdropzone).attr("id") == "reportfiles") {
            var myreportfilesnew = myreportfiles.get(0).dropzone;
            if (myreportfilesnew.files.length != 0) {
                myreportfilesnew.on('sending', function (file, xhr, formData) {
                    formData.append('taskid', id);
                    formData.append('type', $(myreportfiles).attr("id"));
                });
                myreportfilesnew.processQueue();
                myreportfilesnew.on("queuecomplete", function () {
                    location.reload();
                    $('.dz-remove').remove();
                });
            }
        }
        else {
            var myagencyfilesnew = myagencyfiles.get(0).dropzone;
            if (myagencyfilesnew.files.length != 0) {
                myagencyfilesnew.on('sending', function (file, xhr, formData) {
                    formData.append('taskid', id);
                    formData.append('type', $(myagencyfiles).attr("id"));
                });
                myagencyfilesnew.processQueue();
                myagencyfilesnew.on("queuecomplete", function () {
                    location.reload();
                    $('.dz-remove').remove();
                });
            }
        }
    });


    $('#copy').tooltip({
        trigger: 'click',
        placement: 'bottom'
    });

    // Clipboard
    var clipboard = new ClipboardJS('#copy');

    clipboard.on('success', function (e) {
        setTooltip('Copied!');
        hideTooltip();

    });

    clipboard.on('error', function (e) {
        setTooltip('Failed!');
        hideTooltip();

    });
});

