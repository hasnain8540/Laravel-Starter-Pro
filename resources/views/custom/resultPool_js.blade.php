<script>
    $(document).ready(function () {
        $('#exx_pool_category,#existingResultPool').select2({
            dropdownParent: $('#existingResultPoolModal')
        });
        $("#dropdownPool").select2({
            dropdownParent: $("#newResultPool")
        });

        $("#exx_pool_category").select2({
            dropdownParent: $("#existingResultPoolModal")
        });
    });

    function test() {
        let category = $('#exx_pool_category').find(':selected').val();

        $.ajax({
            type: "get",
            url: "{{ route('get.existingPool') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                category: category
            },
            success: function (response) {
                $('#existingResultPool').find('option').remove();
                for (let b = 0; b < response.existingPool.length; b++) {
                    $('#existingResultPool').append('<option value="' + response.existingPool[b].id + '">' + response.existingPool[b]['name'] + '</option>');
                }
            },

        })
    }

    $(document).on('change', '#exx_pool_category', function () {
        var optionSelected = $(this).find("option:selected");
        var category = optionSelected.val();
        alert();

    });

        $(document).on('click', '.result_pools', function() {
        var validateAllPayrolls = [];

        $('.result_pools').map(function() {
            if ($(this).is(':checked'))
            {
                validateAllPayrolls.push(true);
            }
            else
            {
                validateAllPayrolls.push(false);
            }
        });

        const count = validateAllPayrolls.filter((value) => value).length;

        if(count == '0') {
            $('.sendToPool').hide('slow');
        } else {
            $('.sendToPool').show('slow');
        }
    });

    $(document).on('click', '#newPoolBtn', function () {

        let name = $('#pool_name').val();
        let pool_category = $('#pool_category').val();

        var required_inputs = $('input,textarea,select').filter('[required]:visible');
        var count = 0;

        for(var i = 0; i < required_inputs.length; i++){
            var ids = required_inputs[i].id;
            $('#error-'+ids).fadeOut('slow');
            $('#'+ids).css('border', '1px solid lightgrey');
            var vals = required_inputs[i].value;
            if(vals == ''){
                $('#error-'+ids).fadeIn('slow');
                count++;
                $('#'+ids).css('border', '1px solid red');
            }
        }

        if(count > 0){
            setTimeout(function () {
                toastr['error'](
                    'Error! Some Required Fields are not valid.',
                    'Error!',
                    {
                        closeButton: true,
                        tapToDismiss: true
                    }
                );
            }, 2000);
            return false;
        }

        let resultPoolPart = [];

        $('.result_pools').map(function() {
            if ($(this).is(':checked'))
            {
                resultPoolPart.push(
                    {
                        'part_id': $(this).data('pool_part_id')
                    }
                );
            }
        });

        $.ajax({
            type: "post",
            url: "{{ route('resultPool.newPart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                parts: resultPoolPart,
                name: name,
                pool_category: pool_category
            },
            cache: false,
            success: function (response) {
                if (response.success) {
                    setTimeout(function () {
                        toastr['success'](
                            'Success! Part Added Successfully to Pool',
                            'Success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);

                    $('#newResultPool').modal('hide');
                }
            },
            error:function(e){
                setTimeout(function () {
                    toastr['error'](
                        'Error! Some Required Fields are not valid.',
                        'Error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
            }
        })
    });

    // Existing Pool Code
    $(document).on('click', '#existingPoolBtn', function () {

        let name = $("#existingResultPool option:selected" ).val();

        if(name == '') {
            $('#existingResultPool').css('border', '1px solid red');
            $('#error-existingResultPool').fadeIn('slow');
            return false;
        } else {
            $('#existingResultPool').css('border', '1px solid lightgrey');
            $('#error-existingResultPool').fadeOut('slow');

        }
        let resultPoolPart = [];

        $('.result_pools').map(function() {
            if ($(this).is(':checked'))
            {
                resultPoolPart.push(
                    {
                        'part_id': $(this).data('pool_part_id')
                    }
                );
            }
        });

        $.ajax({
            type: "post",
            url: "{{ route('resultPool.existing') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                parts: resultPoolPart,
                name: name
            },
            cache: false,
            success: function (response) {
                if (response.success) {
                    setTimeout(function () {
                        toastr['success'](
                            'Success! Part Added Successfully to Pool',
                            'Success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);

                    $('#existingResultPoolModal').modal('hide');
                }
            },
            error:function(e){
                setTimeout(function () {
                    toastr['error'](
                        'Error! Some Required Fields are not valid.',
                        'Error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
            }
        })
    });

    $(document).on('click', '#createPoolNew', function() {

        // Initialize Select2
        $('.dropdownPool').select2({
            placeholder: "Select Option"
        });
    })
</script>
