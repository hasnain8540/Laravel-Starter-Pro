<script>
    // part/dashboard.blade search on part no
    $(document).on('keydown', '#dashboard-part-no', function () {
        let partNo = $(this).val();
        $("#part-no-datalist").empty();
        if (partNo.length > 0) {
            partNo = partNo.trim();
            // setTimeout(function() {
            $.ajax({
                url: "{{ route('part.search') }}",
                method: "get",
                data: {
                    partNo: partNo
                },
                success: function (response) {
                    let parts = response.parts;
                    $("#part-no-datalist").empty();
                    if (response.success == true) {
                        parts.forEach(part => {
                            $('#part-no-datalist').append($('<option>', {
                                value:part.part_no
                            }));
                        });
                    } else if (response.success == false) {
                        toastr.error(response.msg);
                    }
                }
            });
        // }, 500);
        }else{
            $("#part-no-datalist").empty();
        }
    });
    $('.dashboardFamily').on('click',function () {
        $('#dashboardFamilyModal').modal('show');
            generateFamilyTable($(this).data("id"));

    })
    //function will generate family tabel
    function generateFamilyTable(part_id){
        $.ajax({
            type: "get",
            url: "{{ route('part.familyGet') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part: part_id,
            },
            dataType : 'json',
            success:function(response) {
                if (response.success) {

                    $('.familyTimeline').empty();

                    $('.familyTimeline').html(response.code);

                }
            }
        })
    };
    //deattach all part
    function deAttach(part_id) {
        $('#deAttachPart').val(part_id);
        $('#detachVariation').modal('show');
    }

    // $(document).on('change', '#dashboard-part-no', function () {
    //     alert($(this).val());
    // });
 </script>
