$(document).ready(function () {
    var table = $('#ctable').DataTable({
        ajax: {
            url: "/api/couriers",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Courier',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#iform").trigger("reset");
                    $('#courierModal').modal('show');
                    $('#courierUpdate').hide();
                    $('#courierSubmit').show();
                    $('#courierImages').remove();
                }
            }
        ],
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'courier_name', title: 'Courier Name' },
            { data: 'contact_number', title: 'Contact Number' },
            { data: 'email', title: 'Email' },
            { data: 'service_area', title: 'Service Area' },
            {
                data: 'img_path',
                title: 'Image',
                render: function (data, type, row) {
                    var imgPaths = data.split(',');
                    var imagesHTML = '';
                    imgPaths.forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" width="50" height="60" style="margin-right: 5px;">`;
                        }
                    });
                    return imagesHTML;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function (data, type, row) {
                    return `<a href='#' class='editBtn' data-id="${data.id}"><i class='fas fa-edit' style='font-size:24px'></i></a>
                            <a href='#' class='deleteBtn' data-id="${data.id}"><i class='fas fa-trash-alt' style='font-size:24px; color:red'></i></a>`;
                }
            }
        ],
    });

    $("#courierSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#iform')[0];
        let formData = new FormData(data);
        $.ajax({
            type: "POST",
            url: "/api/couriers",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $("#courierModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#ctable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        $('#courierImages').remove();
        $('#courierId').remove();
        $("#iform").trigger("reset");

        var id = $(this).data('id');
        $('<input>').attr({ type: 'hidden', id: 'courierId', name: 'id', value: id }).appendTo('#iform');
        $('#courierModal').modal('show');
        $('#courierSubmit').hide();
        $('#courierUpdate').show();

        $.ajax({
            type: "GET",
            url: `/api/couriers/${id}`,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#courier_name_id').val(data.courier_name);
                $('#email_id').val(data.email);
                $('#contact_id').val(data.contact_number);
                $('#service_area_id').val(data.service_area);

                var imagesHTML = '';
                data.img_path.split(',').forEach(function (path) {
                    if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                        imagesHTML += `<img src="${path}" width='200px' height='200px'>`;
                    }
                });
                $("#iform").append("<div id='courierImages'>" + imagesHTML + "</div>");
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#courierUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#courierId').val();
        var data = $('#iform')[0];
        let formData = new FormData(data);
        formData.append("_method", "PUT");
        $.ajax({
            type: "POST",
            url: `/api/couriers/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#courierModal').modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#ctable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        bootbox.confirm({
            message: "Do you want to delete this Courier?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: `/api/couriers/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            table.row($row).remove().draw();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    });
});
