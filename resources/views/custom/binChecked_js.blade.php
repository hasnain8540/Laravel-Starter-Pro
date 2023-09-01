<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>

<script>

    window.setInterval(function(){

        $("#reader").focus();
    }, 5000);
    let bin_id =@json($data->id);

    function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        html5QrcodeScanner.clear();

        updateScannedPart(decodedResult, 'withScanner')

    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {fps: 15, qrbox: 250});
    html5QrcodeScanner.render(onScanSuccess);


    $('#reader').keydown(function (e) {

        if (e.which == 13) {
            let decodedResult = $(this).val()
            updateScannedPart(decodedResult)
        }
    })


    function updateScannedPart(decodedResult) {

        $.ajax({
            type: "post",
            url: "{{ route('productionBin.partStore') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'decodedResult': decodedResult,
                'bin_id': bin_id
            },
            success: function (response) {
                console.log(response);
                console.log("juniad");
                $('#reader').val('');
                if (response.success == true) {

                    if (response.data.new) {

                        $('.newBinCard').show();
                    } else {

                        $('.newBinCard').hide();
                    }

                    $('#newPartBody').empty();

                    let status = (response.data.new.status == 'checked') ? '<span class="badge badge-light-primary">Checked</span>' : '<span class="badge badge-light-danger">VERIFY BIN</span>';

                    $('#newPartBody').append(
                        `
                            <tr>
                                <td><img src="https://milanus.aleem.dev/images/internal100/`+response.data.new.part.part_no+`/Def/50/50" width="50px" height="50px"></td>
                                <td>`+response.data.new.part.part_no+`</td>
                                <td>`+response.data.new.part.desc+`</td>
                                <td>`+status+`</td>
                            </tr>
                        `
                    );

                    $('#oldPartBody').empty();
                    var count = 1;

                    for (var i = 0; i < response.data.old.length; i++) {

                        let status = (response.data.old[i].status == 'checked' || response.data.old[i].status == 'recount') ? '<span class="badge badge-light-primary">'+response.data.old[i].status.toUpperCase()+'</span>' : '<span class="badge badge-light-danger">VERIFY BIN</span>';

                        let location = (response.data.old[i].location) ? response.data.old[i].location.name : '';
                        let bin = '';

                        for (let b = 0; b < response.data.old[i].part.bins.length; b++) {

                            let dash = (b != 0) ? '-' : '';
                            bin += '<span>'+dash+' '+response.data.old[i].part.bins[b].bin.name+'</span>';
                        }

                        if (response.data.old[i].part.bins.length == 0) {

                            bin = '--';
                        }

                        let action = '';
                        let dangerClass = (response.data.old[i].status == 'verify bin') ? 'bg-light-danger' : '';

                        if (response.data.old[i].status == 'checked' || response.data.old[i].status == 'recount') {
                            let disable = (response.data.old[i].part.recount.length > 0) ? 'disabled' : '';
                            let recountText = response.data.old[i].part.recount.length > 0 ? 'Under Recount' : 'Recount';
                            action = '<a class="text-gray-400 text-hover-primary mb-1 '+disable+' recountBtn'+response.data.old[i].id+'" href="javascript:void(0)" onclick="recountPart('+response.data.old[i].id+')"><i class="fa fa-calculator"></i> '+recountText+'</a>';
                        } else {

                            action += '<a class="text-gray-400 text-hover-primary mb-1 manageBinBtn" href="javascript:void(0)" onclick="manageBinBtn('+response.data.old[i].part.id+')" data-bs-toggle="modal" data-bs-target="#inventory_bin_created" data-module_id="'+response.data.old[i].bin_checked_id+'" data-id="'+response.data.old[i].part.id+'"><i class="fa fa-th-large"></i>&nbsp; Bins</a>';
                            action += '<a href="javascript:void(0)" class="text-gray-400 text-hover-danger remove-bin-part" data-bin_detail_id="'+response.data.old[i].id+'" data-bs-toggle="modal" data-bs-target="#removePartModal"> <i class="fa fa-trash"></i> Remove</a>';
                        }

                        $('#oldPartBody').append(
                            `
                                <tr class="`+dangerClass+`">
                                    <td class="text-center">`+count+`</td>
                                    <td>`+response.data.old[i].part.part_no+`</td>
                                    <td>`+response.data.old[i].part.desc+`</td>
                                    <td>`+response.data.old[i].qty+`</td>
                                    <td>`+location+`</td>
                                    <td>`+bin+`</td>
                                    <td>`+status+`</td>
                                    <td>`+action+`
                                        <a class="text-gray-400 text-hover-primary mb-1" href="javascript:void(0)"
                                           data-bs-toggle="modal" data-part_no="`+response.data.old[i].part.part_no+`"
                                           data-part_id="`+response.data.old[i].part.id+`" data-desc="`+response.data.old[i].part.desc+`"
                                           data-uom="`+response.data.old[i].part.uom+`" data-bs-target="#inventory_modal"
                                           id="inventory_btn"><i class="fa fa fa-cog"></i> Fix Inventory</a>
                                    </td>
                                </tr>
                            `
                        );

                        count++;
                    }

                    toastr.success(response.message);

                } else if (response.exists == true) {

                    toastr.error(response.message)
                }  else {

                    toastr.error(response.message)
                }

            },
            error: function (response) {
                toastr.error('Something Went wrong')
            }

        })
    }

    // Recount Part
    function recountPart(id) {

        $.ajax({
            type: "get",
            url: "{{ route('productionBin.partRecount') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success:function(response) {
                if (response.success) {

                    $('#oldPartBody').empty();
                    var count = 1;

                    for (var i = 0; i < response.data.length; i++) {

                        let status = (response.data[i].status == 'checked' || response.data[i].status == 'recount') ? '<span class="badge badge-light-primary">'+response.data[i].status.toUpperCase()+'</span>' : '<span class="badge badge-light-danger">VERIFY BIN</span>';

                        let location = (response.data[i].location) ? response.data[i].location.name : '';
                        let bin = '';

                        for (let b = 0; b < response.data[i].part.bins.length; b++) {

                            let dash = (b != 0) ? '-' : '';
                            bin += '<span>'+dash+' '+response.data[i].part.bins[b].bin.name+'</span>';
                        }

                        if (response.data[i].part.bins.length == 0) {

                            bin = '--';
                        }

                        let action = '';
                        let dangerClass = (response.data[i].status == 'verify bin') ? 'bg-light-danger' : '';

                        if (response.data[i].status == 'checked' || response.data[i].status == 'recount') {
                            let disable = (response.data[i].part.recount.length > 0) ? 'disable' : '';
                            let recountText = response.data[i].part.recount.length > 0 ? 'Under Recount' : 'Recount';
                            action = '<a class="text-gray-400 text-hover-primary mb-1 '+disable+' recountBtn'+response.data[i].id+'" href="javascript:void(0)" onclick="recountPart('+response.data[i].id+')"><i class="fa fa-calculator"></i> '+recountText+'</a>';
                        } else {

                            action += '<a class="text-gray-400 text-hover-primary mb-1 manageBinBtn" href="javascript:void(0)" onclick="manageBinBtn('+response.data[i].part.id+')" data-bs-toggle="modal" data-bs-target="#inventory_bin_created" data-module_id="'+response.data[i].bin_checked_id+'" data-id="'+response.data[i].part.id+'"><i class="fa fa-th-large"></i>&nbsp; Bins</a>';
                            action += '<a href="javascript:void(0)" class="text-gray-400 text-hover-danger remove-bin-part" data-bin_detail_id="'+response.data[i].id+'" data-bs-toggle="modal" data-bs-target="#removePartModal"> <i class="fa fa-trash"></i> Remove</a>';
                        }

                        $('#oldPartBody').append(
                            `
                                <tr class="`+dangerClass+`">
                                    <td class="text-center">`+count+`</td>
                                    <td>`+response.data[i].part.part_no+`</td>
                                    <td>`+response.data[i].part.desc+`</td>
                                    <td>`+response.data[i].qty+`</td>
                                    <td>`+location+`</td>
                                    <td>`+bin+`</td>
                                    <td>`+status+`</td>
                                    <td>`+action+`
                                        <a class="text-gray-400 text-hover-primary mb-1" href="javascript:void(0)"
                                           data-bs-toggle="modal" data-part_no="`+response.data[i].part.part_no+`"
                                           data-part_id="`+response.data[i].part.id+`" data-desc="`+response.data[i].part.desc+`"
                                           data-uom="`+response.data[i].part.uom+`" data-bs-target="#inventory_modal"
                                           id="inventory_btn"><i class="fa fa fa-cog"></i> Fix Inventory</a>
                                    </td>
                                </tr>
                            `
                        );

                        count++;
                    }

                    toastr.success(response.message);
                }
            }
        })
    }

    // parse Bin Detail id to remove Part
    $(document).on('click', '.remove-bin-part', function () {

        let bin_id = $(this).data('bin_detail_id');

        $('.removeBinPartId').val(bin_id);
    })

    // Delete Bin Part
    function deleteBinPart() {

        let id = $('.removeBinPartId').val();

        $.ajax({
            type: "post",
            url: "{{ route('productionBin.removePart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                if (response.success) {
                    $('#removePartModal').modal('toggle');

                    $('#oldPartBody').empty();
                    var count = 1;

                    for (var i = 0; i < response.data.length; i++) {

                        let status = (response.data[i].status == 'checked' || response.data[i].status == 'recount') ? '<span class="badge badge-light-primary">'+response.data[i].status.toUpperCase()+'</span>' : '<span class="badge badge-light-danger">VERIFY BIN</span>';

                        let location = (response.data[i].location) ? response.data[i].location.name : '';
                        let bin = '';

                        for (let b = 0; b < response.data[i].part.bins.length; b++) {

                            let dash = (b != 0) ? '-' : '';
                            bin += '<span>'+dash+' '+response.data[i].part.bins[b].bin.name+'</span>';
                        }

                        if (response.data[i].part.bins.length == 0) {

                            bin = '--';
                        }

                        let action = '';
                        let dangerClass = (response.data[i].status == 'verify bin') ? 'bg-light-danger' : '';

                        if (response.data[i].status == 'checked' || response.data[i].status == 'recount') {
                            let disable = (response.data[i].part.recount.length > 0) ? 'disable' : '';
                            let recountText = response.data[i].part.recount.length > 0 ? 'Under Recount' : 'Recount';
                            action = '<a class="text-gray-400 text-hover-primary mb-1 '+disable+' recountBtn'+response.data[i].id+'" href="javascript:void(0)" onclick="recountPart('+response.data[i].id+')"><i class="fa fa-calculator"></i> '+recountText+'</a>';
                        } else {

                            action += '<a class="text-gray-400 text-hover-primary mb-1 manageBinBtn" href="javascript:void(0)" onclick="manageBinBtn('+response.data[i].part.id+')" data-bs-toggle="modal" data-bs-target="#inventory_bin_created" data-module_id="'+response.data[i].bin_checked_id+'" data-id="'+response.data[i].part.id+'"><i class="fa fa-th-large"></i>&nbsp; Bins</a>';
                            action += '<a href="javascript:void(0)" class="text-gray-400 text-hover-danger remove-bin-part" data-bin_detail_id="'+response.data[i].id+'" data-bs-toggle="modal" data-bs-target="#removePartModal"> <i class="fa fa-trash"></i> Remove</a>';
                        }

                        $('#oldPartBody').append(
                            `
                                <tr class="`+dangerClass+`">
                                    <td class="text-center">`+count+`</td>
                                    <td>`+response.data[i].part.part_no+`</td>
                                    <td>`+response.data[i].part.desc+`</td>
                                    <td>`+response.data[i].qty+`</td>
                                    <td>`+location+`</td>
                                    <td>`+bin+`</td>
                                    <td>`+status+`</td>
                                    <td>`+action+`
                                        <a class="text-gray-400 text-hover-primary mb-1" href="javascript:void(0)"
                                           data-bs-toggle="modal" data-part_no="`+response.data[i].part.part_no+`"
                                           data-part_id="`+response.data[i].part.id+`" data-desc="`+response.data[i].part.desc+`"
                                           data-uom="`+response.data[i].part.uom+`" data-bs-target="#inventory_modal"
                                           id="inventory_btn"><i class="fa fa fa-cog"></i> Fix Inventory</a>
                                    </td>
                                </tr>
                            `
                        );

                        count++;
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

    // Print Function
    function binPrint(id) {

        $.ajax({
            type: "get",
            url: "{{ route('binPrint') }}",
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

    $(document).on('click', '.manageBinBtn', function () {

        let module = $(this).data('module_id');
        let part = $(this).data('id');

        $('#moduleId').val(module);
        $('#partId').val(part);
    })

    $(document).on('click', '.closeBinBtn', function () {

        let module = $('#moduleId').val();
        let part = $('#partId').val();

        $.ajax({
            type: "get",
            url: "{{ route('bin.recheckedDetail') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part: part,
                module: module
            },
            success: function (response) {
                if (response.success) {

                    $('.newBinCard').hide();
                    $('#oldPartBody').empty();
                    var count = 1;

                    for (var i = 0; i < response.data.length; i++) {

                        let status = (response.data[i].status == 'checked' || response.data[i].status == 'recount') ? '<span class="badge badge-light-primary">'+response.data[i].status.toUpperCase()+'</span>' : '<span class="badge badge-light-danger">VERIFY BIN</span>';

                        let location = (response.data[i].location) ? response.data[i].location.name : '';
                        let bin = '';

                        for (let b = 0; b < response.data[i].part.bins.length; b++) {

                            let dash = (b != 0) ? '-' : '';
                            bin += '<span>'+dash+' '+response.data[i].part.bins[b].bin.name+'</span>';
                        }

                        if (response.data[i].part.bins.length == 0) {

                            bin = '--';
                        }

                        let action = '';
                        let dangerClass = (response.data[i].status == 'verify bin') ? 'bg-light-danger' : '';

                        if (response.data[i].status == 'checked' || response.data[i].status == 'recount') {
                            let disable = (response.data[i].part.recount.length > 0) ? 'disable' : '';
                            let recountText = response.data[i].part.recount.length > 0 > 0 ? 'Under Recount' : 'Recount';

                            action = '<a class="text-gray-400 text-hover-primary mb-1 '+disable+' recountBtn'+response.data[i].id+'" href="javascript:void(0)" onclick="recountPart('+response.data[i].id+')"><i class="fa fa-calculator"></i> '+recountText+'</a>';
                        } else {

                            action += '<a class="text-gray-400 text-hover-primary mb-1 manageBinBtn" href="javascript:void(0)" onclick="manageBinBtn('+response.data[i].part.id+')" data-bs-toggle="modal" data-bs-target="#inventory_bin_created" data-module_id="'+response.data[i].bin_checked_id+'" data-id="'+response.data[i].part.id+'"><i class="fa fa-th-large"></i>&nbsp; Bins</a>';
                            action += '<a href="javascript:void(0)" class="text-gray-400 text-hover-danger remove-bin-part" data-bin_detail_id="'+response.data[i].id+'" data-bs-toggle="modal" data-bs-target="#removePartModal"> <i class="fa fa-trash"></i> Remove</a>';
                        }

                        $('#oldPartBody').append(
                            `
                                <tr class="`+dangerClass+`">
                                    <td class="text-center">`+count+`</td>
                                    <td>`+response.data[i].part.part_no+`</td>
                                    <td>`+response.data[i].part.desc+`</td>
                                    <td>`+response.data[i].qty+`</td>
                                    <td>`+location+`</td>
                                    <td>`+bin+`</td>
                                    <td>`+status+`</td>
                                    <td>`+action+`
                                        <a class="text-gray-400 text-hover-primary mb-1" href="javascript:void(0)"
                                           data-bs-toggle="modal" data-part_no="`+response.data[i].part.part_no+`"
                                           data-part_id="`+response.data[i].part.id+`" data-desc="`+response.data[i].part.desc+`"
                                           data-uom="`+response.data[i].part.uom+`" data-bs-target="#inventory_modal"
                                           id="inventory_btn"><i class="fa fa fa-cog"></i> Fix Inventory</a>
                                    </td>
                                </tr>
                            `
                        );

                        count++;
                    }

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Bin Attached',
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
    })

    $(document).on('click', '#inventory_parent_modal_close', function() {

        let part_no = $('#inventory_parent_modal_part_no').text();
        let module = $('#binCheckedId').val();

        $.ajax({
            type: "get",
            url: "{{ route('binRecheck.LocationDetail') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part: part_no,
                module: module
            },
            success: function (response) {
                if (response.success) {

                    $('.newBinCard').hide();
                    $('#oldPartBody').empty();
                    var count = 1;

                    for (var i = 0; i < response.data.length; i++) {

                        let status = (response.data[i].status == 'checked' || response.data[i].status == 'recount') ? '<span class="badge badge-light-primary">'+response.data[i].status.toUpperCase()+'</span>' : '<span class="badge badge-light-danger">VERIFY BIN</span>';

                        let location = (response.data[i].location) ? response.data[i].location.name : '';
                        let bin = '';

                        for (let b = 0; b < response.data[i].part.bins.length; b++) {

                            let dash = (b != 0) ? '-' : '';
                            bin += '<span>'+dash+' '+response.data[i].part.bins[b].bin.name+'</span>';
                        }

                        if (response.data[i].part.bins.length == 0) {

                            bin = '--';
                        }

                        let action = '';
                        let dangerClass = (response.data[i].status == 'verify bin') ? 'bg-light-danger' : '';

                        if (response.data[i].status == 'checked' || response.data[i].status == 'recount') {
                            let disable = (response.data[i].part.recount.length > 0) ? 'disable' : '';
                            let recountText = response.data[i].part.recount.length > 0 > 0 ? 'Under Recount' : 'Recount';

                            action = '<a class="text-gray-400 text-hover-primary mb-1 '+disable+' recountBtn'+response.data[i].id+'" href="javascript:void(0)" onclick="recountPart('+response.data[i].id+')"><i class="fa fa-calculator"></i> '+recountText+'</a>';
                        } else {

                            action += '<a class="text-gray-400 text-hover-primary mb-1 manageBinBtn" href="javascript:void(0)" onclick="manageBinBtn('+response.data[i].part.id+')" data-bs-toggle="modal" data-bs-target="#inventory_bin_created" data-module_id="'+response.data[i].bin_checked_id+'" data-id="'+response.data[i].part.id+'"><i class="fa fa-th-large"></i>&nbsp; Bins</a>';
                            action += '<a href="javascript:void(0)" class="text-gray-400 text-hover-danger remove-bin-part" data-bin_detail_id="'+response.data[i].id+'" data-bs-toggle="modal" data-bs-target="#removePartModal"> <i class="fa fa-trash"></i> Remove</a>';
                        }


                        $('#oldPartBody').append(
                            `
                                <tr class="`+dangerClass+`">
                                    <td class="text-center">`+count+`</td>
                                    <td>`+response.data[i].part.part_no+`</td>
                                    <td>`+response.data[i].part.desc+`</td>
                                    <td>`+response.data[i].qty+`</td>
                                    <td>`+location+`</td>
                                    <td>`+bin+`</td>
                                    <td>`+status+`</td>
                                    <td>`+action+`
                                        <a class="text-gray-400 text-hover-primary mb-1" href="javascript:void(0)"
                                           data-bs-toggle="modal" data-part_no="`+response.data[i].part.part_no+`"
                                           data-part_id="`+response.data[i].part.id+`" data-desc="`+response.data[i].part.desc+`"
                                           data-uom="`+response.data[i].part.uom+`" data-bs-target="#inventory_modal"
                                           id="inventory_btn"><i class="fa fa fa-cog"></i> Fix Inventory</a>
                                    </td>
                                </tr>
                            `
                        );

                        count++;
                    }


                }
            },

        })
    })
</script>
