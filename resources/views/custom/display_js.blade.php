<script>

    $(document).ready(function () {

        $("#assign_to").select2({
            dropdownParent: $("#assignJob")
        });
    });

    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }

    var input = document.getElementById("part_no");
    if (input) {
        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                // document.getElementById("insertPart").click();
                document.getElementById("qty").focus();
            }
        });
    }

    var input = document.getElementById("qty");
    if (input) {
        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("insertPart").click();
            }
        });
    }

    $('#insertPart').on('click', function() {

        let part = $('#part_no').val();
        let qty = $('#qty').val();
        let display_id = $('#display_id').val();

        if (Number(qty) == '0') {

            setTimeout(function () {
                toastr['error'](
                    'Error! Qty Must be greater than 0.',
                    'Error!',
                    {
                        closeButton: true,
                        tapToDismiss: true
                    }
                );
            }, 2000);

            return false;
        }

        $.ajax({
            type: "get",
            url: "{{ route('production.storeDisplay') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part: part,
                qty: qty,
                display_id: display_id
            },
            success: function (response) {
                if (response.success) {

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Part Number and Qty was added in list.',
                            'success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);

                    $('#part_no').val('');
                    $('#qty').val('');

                    $('.emptyBody').hide();
                    document.getElementById("part_no").focus();

                    var element = document.getElementById("finishDisplayBtn");
                    element.classList.remove("d-none");

                    var table = document.getElementById("add_display_part");
                    var tbodyRowCount = table.tBodies[0].rows.length; // 3

                    $('#displayPartBody').append(
                        `
                            <tr id="row` + response.data.id + `">
                                <td>` + tbodyRowCount + `</td>
                                <td>` + response.data.part.part_no + `</td>
                                <td>` + response.data.part.desc + `</td>
                                <td><a href="#" style="color: black" class="updateQty" data-bs-toggle="modal" data-bs-target="#updateQtyModal" data-update_part_id="` + response.data.id + `"><p class="textQty` + response.data.id + `" id="textQty` + response.data.id + `">` + response.data.qty + `</p></a> <input type="hidden" class="form-control qtyNew` + response.data.id + `" value="` + response.data.qty + `"></td>
                                <td>` + response.data.part.category.parent['name_in_english'] + ' >> ' + response.data.part.category['name_in_english'] + `</td>
                                <td>` + formatDateShortMonthName(response.data.created_at) + `</td>
                                <td>
                                    <a href="#" class="text-gray-400 text-hover-danger" onclick="removePart(` + response.data.id + `)">
                                        <i class="fa fa-trash"></i> Remove
                                    </a>
                                </td>
                            </tr>
                        `
                    );

                } else if (response.noExists) {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! No Part Found.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if(response.categoryNotAllowed) {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Part belongs to Restricted Category.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if(response.exists) {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Part Already Added.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if(response.qtyGreater) {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Qty greater than Location.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if(response.partExists) {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Part not Exists on this Location.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                }
            },

        })
    })

    function removePart(id) {

        $('.removePartId').val(id);
        $('#removePartModal').modal('toggle');

    }

    // Delete Display Part
    function deleteDisplayPart() {

        let id = $('.removePartId').val();

        $.ajax({
            type: "get",
            url: "{{ route('productionDisplay.deletePart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                if (response.success) {
                    $('#removePartModal').modal('toggle');

                    $('#row'+response.id).remove();

                    var table = document.getElementById("add_display_part");
                    var tbodyRowCount = table.tBodies[0].rows.length; // 3

                    if (tbodyRowCount == '1') {
                        $('.emptyBody').show();

                        var element = document.getElementById("finishDisplayBtn");
                        element.classList.add("d-none");
                    }

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Part Number was Removed from list.',
                            'Success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                }
            },

        })
    }

    // Parse Display Id to Finish Display Modal
    $('.finishDisplay').on('click', function () {

        let display_id = $(this).data('display_id');

        $('#finish_display').val(display_id);
    });

    // Parse Display Id to Assign Display Modal
    $('.assignDisplay').on('click', function () {

        let display_id = $(this).data('display_id');

        $('#assign_display').val(display_id);
    });

    // direct assign btn event
    $(document).on('click', '.directAssignBtn', function () {

        let assign_to = $('#assign_to').val();
        let display_id = $('#display_id').val();

        assignJob(assign_to, display_id);
    })

    $(document).on('click', '.requestAssign', function () {

        let assign = $(this).data('assig_id');
        let display_id = $('#display_id').val();

        assignJob(assign, display_id);
    })

    function assignJob(assign, display) {

        $.ajax({
            type: "get",
            url: "{{ route('display.jobAssign') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                assign: assign,
                display: display
            },
            success: function (response) {
                if (response.success) {

                    $('#assignJob').toggle('hide');

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Display job Assigned Successfully.',
                            'success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);

                    setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);

                } else {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Something went wrong.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                }
            },

        })
    }

    // Print Listing
    function PrintElem(elem)
    {
        var mywindow = window.open('', 'PRINT', 'height=800,width=1200');

        var contents = document.getElementById(elem).innerHTML;

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(contents);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();

        return true;
    }

    function changeQty(id)
    {
        $('.textQty'+id).hide();
        let qty = document.getElementById('textQty'+id).textContent;
        $('.qtyNew'+id).show('slow');
        $('.qtyNew'+id).val(qty);
    }

    $(document).on('click', '#updateQtyBtn', function () {

        let id = $('.updatePartId').val();
        let qty = $('.qtyValue').val();

        $.ajax({
            type: "post",
            url: "{{ route('display.updateQtys') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
                qty: qty
            },
            success: function (response) {
                if (response.success) {

                    $('#updateQtyModal').modal('toggle');

                    $('.qtyValue').css('border', '1px solid grey');

                    $('.textQty'+response.id).text(response.qty);
                    $('.textQty'+response.id).show('slow');

                    $('.qtyNew'+response.id).val(response.qty);
                    $('.qtyNew'+response.id).hide();

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Qty Updated Successfully.',
                            'success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);

                } else if(response.qtyGreater) {

                    $('.qtyValue').css('border', '1px solid red');

                    setTimeout(function () {
                        toastr['error'](
                            'Error! Qty greater than Location.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else {

                    setTimeout(function () {
                        toastr['error'](
                            'Error! Something went wrong.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                }
            },

        })
    });

    // Parse Module Id to Module Destroy Modal
    $(document).on('click', '.updateQty', function () {

        let part_id = $(this).data('update_part_id');

        let qty = $('.qtyNew'+part_id).val();

        $('.qtyValue').val(qty);
        $('.updatePartId').val(part_id);
    });

    function displayPrint(id) {
        $.ajax({
            type: "get",
            url: "{{ route('displayPrint') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function (response) {
                var w = window.open('', "_blank", "width=800,height=700");
                var is_chrome = Boolean(w.chrome);
                w.document.write(response);
                if (is_chrome) {
                    setTimeout(function () { // wait until all resources loaded
                        w.document.close(); // necessary for IE >= 10
                        w.focus(); // necessary for IE >= 10
                        w.print(); // change window to winPrint
                        w.close(); // change window to winPrint
                    }, 700);
                } else {
                    w.document.close(); // necessary for IE >= 10
                    w.focus(); // necessary for IE >= 10
                    w.print();
                    w.close();
                }
            },
            error: function (response) {
                toastr.error('Something Went wrong')
            }

        })
    }
</script>
