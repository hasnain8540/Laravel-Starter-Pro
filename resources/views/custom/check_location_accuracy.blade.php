<script>
    function checkLocationAccuracy(location_input_text){

        return new Promise(function(resolve, reject) {
            var ur = '{{ route("location.checkAccuracy",["location_input_text" =>  ":location_input_text"]) }}';
            var url =ur.replace(':location_input_text', location_input_text);
            $.ajax({
                url: url,
                method :'Get',
                dataType : 'json',
                success: function(response){
                    // alert("here in response");
                    // alert(response.success);
                            if(response.success == false){
                                    $("#part_location_input").css("border",'1px solid red');
                                    $("#error-part_location_input").css("display","block");
                                    $("#error-part_location_input").empty();
                                    $("#error-part_location_input").text(response.msg);
                                    resolve(false);
                            }
                            else{
                                    $("#part_location_input").css("border",'');
                                    $("#error-part_location_input").css("display","none");
                                    $("#error-part_location_input").empty();
                                    $("#error-part_location_input").text('Location is Required.');
                                    resolve(true);
                            }
                            // return error;
                },
                error: function(response){
                    reject(response);
                }
            });
        });
      
    }
</script>