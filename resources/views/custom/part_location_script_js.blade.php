{{--  @include('custom.location_dropdown_js');  --}}
<script>
    //   create part location field
    {{--  $(document).on('keydown', function (e) {
        if ($("#parts-locations").css("display") == 'block') {
            let listLength = $("#parts-locations li").length;
            let focusedInput = e.target.id == 'part_location_input' ? 'part_location_input' : '';
            let unordereredList = 'parts-locations';
            let index = '';
            var list = '';
            if (listLength > 0) {
                switch (e.which) {
                    // down arrow key
                    case 40: {
                        // debugger
                        if (focusedInput) {
                            $("#" + focusedInput).blur();
                        }
                        index = $("#parts-locations li.loc_active").data("index");
                        list = document.getElementById("parts-locations").querySelectorAll(".location_li");

                        if (index == undefined || index == null) {
                            index = 0;
                        }

                        let active = list[index];
                        // iterate list
                        for (let i = 0; i < list.length; i++) {
                            list[i].classList.remove("loc_active");
                        }
                        if (active) {
                            if (index == 0) {
                                active.classList.add("loc_active");
                                window.stop();
                            } else {
                                active.classList.add("loc_active");
                                return true;
                            }
                        }
                        break;
                    }
                    // up arrow key
                    case 38: {
                        e.preventDefault();
                        if (focusedInput) {
                            $("#" + focusedInput).blur();
                        }
                        index = $("#" + unordereredList + " li.loc_active").data("index");
                        list = document.getElementById("parts-locations").querySelectorAll(".location_li");
                        if (index == undefined || index == null) {
                            index = listLength;
                            let active = list[index - 1];

                            // iterate lists
                            for (let i = 0; i < list.length; i++) {
                                list[i].classList.remove("loc_active");
                            }

                            if (list[index - 2]) {
                                active.classList.add("loc_active");
                            }
                        } else {
                            let active = list[index - 1];

                            // iterate list
                            for (let i = 0; i < list.length; i++) {
                                list[i].classList.remove("loc_active");
                            }
                            if (list[index - 2]) {
                                list[index - 2].classList.add("loc_active");
                            }
                        }


                        break;
                    }
                    // Enter Key
                    case 13: {
                        let value = $('#' + unordereredList + ' li.loc_active').html();
                        setTimeout(function () {
                            $('#part_location_input').val(value);
                            $("#" + unordereredList).css('display', 'none');
                        }, 300);
                        break;
                    }
                    default: {

                    }
                }
            }
        }

    });

    // on click in location list enter that into input field
    $(document).on('click', '.location_li', function (e) {
        let id = $(this).parent().attr('id');

        if (id == 'parts-locations') {
            let value = $(this).html();
            $("#part_location_id").val($(this).data("location_id"));
            $("#part_location_input").val(value);
            $("#parts-locations").empty();
            $("#parts-locations").css('display', 'none');
        }
    });

    //   function to check if dropdown is opened and the clicked event is fired outside of dropdown and input field
    $(document).on('click', function (e) {
        let id = '';
        let clickedItemClass = event.target.classList;
        if ($("#parts-locations").css('display') == 'block') {
            if (!event.target.classList.contains(".location_li") && !event.target.classList.contains(
                    "part_create_location")) {
                $("#parts-locations").css('display', 'none');
            }
        }
    });  --}}

    // Location autocomplete
    $('.locationInput').on('keyup', function () {
        const input = $(this);
        const val = input.val();

        if (val.length > 1) {
            $.ajax({
                type: "get",
                url: "{{ route('filter.AddLocations') }}",
                data: {
                    value: val
                },
                success: function (response) {

                    const locationArray = Object.entries(response).map(([key, record]) => ({
                        label: record,
                        value: key
                    }));

                    input.autocomplete({
                        source: locationArray,
                        delay: 0,
                        select: function (event, ui) {
                            input.val(ui.item.label);
                            updateLocation(ui.item.value);
                            return false;
                        },
                        focus: function (event, ui) {

                            input.val(ui.item.label);
                            return false;
                        }

                    });
                }
            });
        }
    });

    // Update Location Id
    function updateLocation(id) {

        $('.part_location_id').val(id);
    }

</script>
