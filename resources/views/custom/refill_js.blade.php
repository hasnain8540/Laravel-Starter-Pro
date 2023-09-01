<script>
    let refillStatus =@json($data->status);
    let refillId =@json($data->id);
    if (refillStatus === 'refilling') {
        setInterval(function () {
            // updateTime(refillId)
        }, 30000)
    }


    function updateTime() {
        $.ajax({
            type: "post",
            url: "{{ route('refill.updateTime') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                refillId: refillId
            },
            success: function (response) {
                console.log('time updated')
            },
        })
    }

    $(document).ready(function () {
        //Select 2 in asssign select
        $('#assign_to').select2({
            dropdownParent: $('#assignJob')
        });
        if (refillStatus === 'refilling') {

            updateTime(refillId)
        }

    });

    function sendToRefill(id, refil) {

        $.ajax({
            type: "get",
            url: "{{ route('refill.send') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
                refill: refil
            },
            success: function (response) {
                if (response.success) {

                    var element = document.getElementById("sendRefill" + response.data.id);
                    $(element).parent().closest('tr').find('span:eq(0)').removeClass().addClass('badge badge-light-primary').text('Waiting')
                    clickRefill(refil)
                    element.classList.add("d-none");

                    var element = document.getElementById("inProgress" + response.data.id);
                    element.classList.remove("d-none");

                    var element = document.getElementById("finishRefill");
                    element.classList.remove("d-none");

                    var element = document.getElementById("deleteRefill");
                    element.classList.add("d-none");

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Part Send to Refill Successfully',
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

    $('.finishRefillBtn').on('click', function() {

        let id = $(this).data('finish_refill_id');

        $('#finish_refill').val(id);
    })

    // Refilled Part
    function refilledPart(id) {

        $.ajax({
            type: "get",
            url: "{{ route('refill.refilled') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                if (response.success) {

                    var element = document.getElementById("recount" + response.data.id);
                    element.classList.add("d-none");
                    $(element).parent().closest('tr').find('span:eq(0)').removeClass().addClass('badge badge-light-success').text('Refilled')


                    var element = document.getElementById("bin" + response.data.id);
                    element.classList.add("d-none");

                    var element = document.getElementById("refilled" + response.data.id);
                    element.classList.add("d-none");

                    var element = document.getElementById("refilledDone" + response.data.id);
                    $(element).parent().closest('tr').find('td:last-child').removeClass().text('--')


                    $('#refillStatus').empty();


                    if (response.item.status == 'refilling') {

                        $('#refillStatus').html('<span class="badge badge-light-primary">Refilling</span>');
                    } else if (response.item.status == 'selection') {

                        $('#refillStatus').html('<span class="badge badge-light-warning">Selection</span>');
                    } else {

                        $('#refillStatus').html('<span class="badge badge-light-success">Finished</span>');
                        $('#dateFinished').html(response.item.date_finished)
                        location.reload()
                    }

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Part Send Refilled Successfully',
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

    function recountPart (id) {

        $.ajax({
            type: "get",
            url: "{{ route('refill.recount') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                if (response.success) {

                    $('.recountBtn' + response.data.id).attr('disabled', true);
                    $('.recountBtn' + response.data.id).html('<i class="fa fa-calculator"></i> Under Recount');

                }
            },
        })
    }

    // Print Function
    function refillPrint(id) {
        $.ajax({
            type: "get",
            url: "{{ route('refillPrint') }}",
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

    function clickRefill(refil) {
        let statusArray = [];
        let tr = $('#refillStartTable > tbody> tr');
        tr.each(function (index, element) {
            statusArray.push($(element).find('td').eq(1).text().trim());
        })
        statusArray = [...new Set(statusArray)]
        if (statusArray.length == 1) {
            $.ajax({
                type: "post",
                url: "{{ route('refilling.finish') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    finish_refill_id: refil
                },
                success: function (response) {
                    toastr.success('Refill started Successfully')
                    location.reload();
                },
            })


        }
    }
    $('.directAssignBtn').on('click', function () {
        let userId = $('#assign_to').val()
        let refillId = $('#assign_refill_id').val()
        if (userId)
            $.ajax({
                url: "{{route('refilling.assignJob')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': refillId,
                    'userId': userId,
                },
                method: "post",
                success: function (response) {
                    if (response.success == true) {
                        toastr.success('Job is assign successfully ')
                        window.location.reload();
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        else {
            toastr.error('Please Select a user')
        }
    })

    $(document).on('click', '#inventory_parent_modal_close', function() {

        let part_no = $('#inventory_parent_modal_part_no').text();
        let module = $('#refillId').val();
        let location = $('#locationId').val();

        $.ajax({
            type: "get",
            url: "{{ route('refill.qtyRechecked') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part: part_no,
                module: module,
                location: location
            },
            success: function (response) {
                if (response.success) {

                    window.location.reload();
                }
            },

        })
    })

    $(document).on('click', '.closeBinBtn', function () {

        window.location.reload();
    })
</script>
