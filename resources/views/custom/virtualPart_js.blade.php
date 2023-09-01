<script>

    $(document).ready(function () {

        base();
        // Initialize Select2
        $('.dropdown').select2({
            placeholder: "Select Option"
        });

    });

    function base()
    {
        let index = $('#Index').val();
        let part = $('#part_id').val();

        $.ajax({
            type: "get",
            url: "{{ route('virtualPart.baseLoad') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'index': index,
                'part': part
            },
            success:function(response) {
                if (response.success) {

                    // Set Title and Index
                    $('#title').html(response.title+' ( '+response.index+'/10 )');
                    // Set ProgressBar
                    let width = (response.index/4)*100;
                    document.getElementById("progressBar").style.width = width+"%";

                    // show Part Step in Form
                    if (response.index == '0') {
                        $('#divPart0').fadeIn('slow');
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').hide();

                        $('#partCancel').text('Cancel');
                        $('#saveForm').text('Start Creation');
                    } else if (response.index == '1') {
                        $('#divPart0').hide();
                        $('#divPart1').fadeIn('slow');
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '2') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').fadeIn('slow');
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '3') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').fadeIn('slow');
                        $('#length').focus();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '4') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').fadeIn('slow');
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    }

                }
            }
        })
    }

</script>
