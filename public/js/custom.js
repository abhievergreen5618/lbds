$(document).ready(function () {
    console.log("load");
    $('#inspectiontable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "inspectiontypedata",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});