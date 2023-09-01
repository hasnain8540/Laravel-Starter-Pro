<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script type="text/javascript">

    let alt = '';
    {{--let part_id=@json($part->id);--}}
    $('#ImageUploadposition').change(function(){
        $("div").filter(".d-none").removeClass('d-none');
    });


    $('#ImageUploadposition').change(function() {
        let value = $("#ImageUploadposition option:selected").val();
        alt = value;
    });

    Dropzone.autoDiscover = false;

    $("#id_dropzone").dropzone({
        addRemoveLinks: true,
        maxFiles: 50,
        uploadMultiple: true,
        parallelUploads: 5,
        acceptedFiles: ".jpg",
        url: "{{ route('part.imageUpload') }}",
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("position", alt);
                formData.append("part", part_id);
            });
            this.on("removedfile", function(file) {

                var name = file.name;
                $.ajax({
                    type: 'POST',
                    url: "{{route('part.imageDelete')}}",
                    data: {
                        image: name,
                        position:alt,
                        part:part_id,
                    },

                    success:function(data)
                    {
                        // setTimeout(function () {
                        //             toastr['success'](
                        //                 'Image'+name+' Deleted Successfully',
                        //                 'Success!',
                        //                 {
                        //                     closeButton: true,
                        //                     tapToDismiss: true
                        //                 }
                        //             );
                        //         }, 2000);

                    },
                    error: function(){
                        setTimeout(function () {

                            toastr['error'](
                            'Error! Something went Wrong',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                    }

                });
            });
        },
        success: function (file, response) {
            if(response.response=="Already Exist"){
                setTimeout(function () {
                    toastr['error'](
                        'Image '+file.name+' Already Exist',
                        'Error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
            }
            else if(response.response=="Added Successfully"){
            setTimeout(function () {
                toastr['success'](
                    'Image '+file.name+' was successfully uploaded to Dropbox',
                    'Success!',
                    {
                        closeButton: true,
                        tapToDismiss: true
                    }
                );
            }, 2000);
            }else{
                setTimeout(function () {

                    toastr['error'](
                        'Error! Something went Wrong',
                        'Error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
            }
        },
        error: function(){
            setTimeout(function () {

                toastr['error'](
                    'Error! Something went Wrong',
                    'Error!',
                    {
                        closeButton: true,
                        tapToDismiss: true
                    }
                );
            }, 2000);
        }
    });

</script>
