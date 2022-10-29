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
    var sendinvoicetable = $('#sendinvoicetable').DataTable({
        "processing": true,
        "serverSide": true,
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
    function select2call() {
        $('.inspectorlist').select2({
            placeholder: "Assign Inspector",
            tags: true,
        });
    }
    var requesttable = $('#requesttable').DataTable({
        "preDrawCallback": function (settings) {
            setTimeout(function () {
                select2call();
            }, 1000);
        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "requestdetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" },
            { "width": "30%", "targets": 5 }
        ],
        "columns": [
            {
                "data": "company_id",
            },
            {
                "data": "applicantname",
            },
            {
                "data": "address",
            },
            {
                "data": "inspectiontype",
            },
            {
                "data": "created_at",
            },
            {
                "data": "assigned_inspector",
            },
            {
                "data": "status",
            },
            {
                "data": "action",
            },
        ],
    });
    var companyrequesttable = $('#companyrequesttable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "companyrequestdetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" },
            { "width": "30%", "targets": 5 }
        ],
        "columns": [
            {
                "data": "inspectiontype",
            },
            {
                "data": "applicantname",
            },
            {
                "data": "address",
            },
            {
                "data": "city",
            },
            {
                "data": "zipcode",
            },
            {
                "data": "created_at",
            },
            {
                "data": "status",
            },
           
        ],
    });
    requesttable.on('click', '.delete', function () {
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
                    url: 'request-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        requesttable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    requesttable.on('click', '.cancel', function () {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = $(this).attr('data-id');
        Swal.fire({
            title: 'Confirmation',
            input: 'textarea',
            inputLabel: 'Are you sure you want to cancel?',
            inputPlaceholder: 'Please write the reason',
            inputAttributes: {
                'aria-label': 'Type your message here'
              },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'request-cancel',
                    data: {
                        id: userid,
                        msg : result.value,
                    },
                    dataType: 'json',
                    success: function (data) {
                        toastr.success(data.msg);
                        requesttable.ajax.reload();
                    },
                    error: function (data) {
                        if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                            $('.preloader').children().hide();
                            $('.preloader').css("height", "0");
                            toastr.error(xhr.responseJSON.msg);
                        }   
                    }
                });
            };
        });
    });

    var inspectortable = $('#inspectortable').DataTable({
        "processing": true,
        "serverSide": true,
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
    $('nav .nav-item a').click(function (e) {
        $('.nav-item').removeClass('menu-is-opening menu-open');
        $('.nav .nav-treeview').css('display', 'none');
        $(this).parent('li .nav-link').addClass('menu-is-opening menu-open');
        $(this).find('ul').css('display', 'block');
    });


    var usertable = $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
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
    requesttable.on('select2:selecting', '.inspectorlist', function (sel) {
        $(this).find("option[value=" + sel.params.args.data.id + "]").each(function (e) {
            element = $(this);
            var insid = $(this).val();
            var reqid = $(this).attr('data-req-id');
            if (insid.length && reqid.length) {
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
                        $('.preloader').children().show();
                        $('.preloader').css("height", "100vh");
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            url: 'inspectorassign',
                            data: {
                                id: insid,
                                reqid: reqid,
                            },
                            dataType: 'json',
                            success: function (data) {
                                $('.preloader').children().hide();
                                $('.preloader').css("height", "0");
                                toastr.success(data.msg);
                                requesttable.ajax.reload();
                            },
                            error: function (xhr) {
                                if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                                    $('.preloader').children().hide();
                                    $('.preloader').css("height", "0");
                                    toastr.error(xhr.responseJSON.msg);
                                }
                            }
                        });
                    };
                });
            }
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
        acceptedFiles: ".jpeg,.jpg,.png,.pdf",
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
        acceptedFiles: ".jpeg,.jpg,.png,.pdf",
        removedfile: function (file) {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode
                .removeChild(
                    file.previewElement) : void 0;
        },
    });

    $('#submit-btn').click(function () {
        if ($('#requestform').valid()) {
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
            return false;
        }
    });
});