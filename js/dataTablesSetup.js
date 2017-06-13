$(document).ready(function () {
    $('.dataTables-entries').DataTable({
        "language": {
            "url": "js/dataTables-portuguese-Brazil.json"
        },
        dom: '<"html5buttons" B>lTfgitp',
        buttons: [
            {
                extend: 'pdfHtml5'
                /*exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }*/
            },
            'colvis'
        ]

    });
});