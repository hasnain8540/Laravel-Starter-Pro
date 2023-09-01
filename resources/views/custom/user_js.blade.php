<script>
    $(document).ready(function () {


        // default locations
        $(document).on('click', '.defaultlocation', function () {
            var location_group_id = $(this).closest('tr').data('location_group_id');
            let defaultGroupCount = 0;
            $('.defaultlocation').each(function () {
                if ($(this).is(':checked')) {
                    defaultGroupCount++;
                }
            });



            if (!($(this).closest('tr').find('.activelocation').is(':checked'))) {
                $(this).prop('checked', false);
                toastr.error('For default, location must be active');
            } else if (defaultGroupCount > 1) {
                toastr.error('Only one default group is allowed per user');
                $(this).prop('checked', false);
            }else{
                $(this).val(location_group_id);
                $(this).closest('tr').find('.defaultGroup').html('<span class="badge badge-light-success fs-7 fw-bolder">Default</span>');
            }

            if((!$(this).is(':checked'))){
                $(this).val('');
                $(this).closest('tr').find('.badge').remove();
            }

        });
        // on activate location add it to active locations array
        $(document).on('click', '.activelocation', function () {
            var location_group_id = $(this).closest('tr').data('location_group_id');
                if ($(this).is(':checked')) {
                   $(this).val(location_group_id);
                }else{
                    $(this).val('');
                }
                if(!($(this).is(':checked'))){
                    $(this).closest('tr').find('.defaultlocation').prop('checked', false);
                    $(this).closest('tr').find('.defaultlocation').val('');
                    $(this).closest('tr').find('.badge').remove();

                }
        });
        //  user submisson
        $("#user_create_form").submit(function (event) {
            // event.preventDefault();
            let location_group_id;
            let defaultGroupCount = 0;
            $('.defaultlocation').each(function () {
            location_group_id = $(this).closest('tr').data('location_group_id');
                if ($(this).is(':checked')) {
                    defaultGroupCount++;
                    $(this).val(location_group_id);
                }
            });
            let activeLocationCount = 0;
            $('.activelocation').each(function () {
             location_group_id = $(this).closest('tr').data('location_group_id');
                if ($(this).is(':checked')) {
                    activeLocationCount++;
                    $(this).val(location_group_id);
                }
            });
            if (defaultGroupCount != 1) {
                $("#default_location_error").html('One default group must be selected');
            } else {
                $("#default_location_error").html('');
            }
            if (activeLocationCount < 1) {
                $("#active_location_error").html('One active group must be selected');
            } else {
                $("#active_location_error").html('');
            }
            if (defaultGroupCount == 1 && activeLocationCount > 0) {
                $("#create_user_btn").attr('type', 'submit');
                $('#user_create_form').submit();
            } else {
                event.preventDefault();
            }

        });
        //  user updation
        $("#user_update_form").submit(function (event) {
            // event.preventDefault();
            let location_group_id;
            let defaultGroupCount = 0;
            $('.defaultlocation').each(function () {
            location_group_id = $(this).closest('tr').data('location_group_id');
                if ($(this).is(':checked')) {
                    defaultGroupCount++;
                    $(this).val(location_group_id);
                }
            });
            let activeLocationCount = 0;
            $('.activelocation').each(function () {
             location_group_id = $(this).closest('tr').data('location_group_id');
                if ($(this).is(':checked')) {
                    activeLocationCount++;
                    $(this).val(location_group_id);
                }
            });
            if (defaultGroupCount != 1) {
                $("#default_location_error").html('One default group must be selected');
            } else {
                $("#default_location_error").html('');
            }
            if (activeLocationCount < 1) {
                $("#active_location_error").html('One active group must be selected');
            } else {
                $("#active_location_error").html('');
            }
            if (defaultGroupCount == 1 && activeLocationCount > 0) {
                $("#update_user_btn").attr('type', 'submit');
                $('#user_update_form').submit();
            } else {
                event.preventDefault();
            }

        });

    });

    // Log Tab
    $(document).on('click', '#userLogTab', function () {

        let user = $('#user').val();

        $.ajax({
            type: "get",
            url: "{{ route('user.logGet') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                user: user
            },
            success:function(response) {
                if (response.success) {

                    $('#logTimeline').empty();

                    $('#logTimeline').html(response.code);

                    $(function() {
                        $(".paginate").paginga({
                            // use default options
                        });

                        $(".paginate-page-2").paginga({
                            page: 2
                        });

                        $(".paginate-no-scroll").paginga({
                            scrollToTop: false
                        });
                    });
                }
            }
        })
    });


</script>

