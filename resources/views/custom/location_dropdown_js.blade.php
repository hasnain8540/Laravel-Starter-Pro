<script>
     $(document).on('keyup',function(e){
        let locationFieldId =e.target.id;
        let locationFieldValue = e.target.value;
        let locationUlId = '';
        let inputCharCount = 0;
        if(locationFieldId == 'part_location_input' || locationFieldId == 'add_locations' || locationFieldId == 'datalis-move' || locationFieldId == 'recount-loc'){
            locationFieldValue = locationFieldValue.trim();
            locationUlId = $("#"+locationFieldId).next().attr("id");
            inputCharCount = locationFieldValue.length;
           
            if(inputCharCount <= 1 || locationFieldValue == ''){
                $("#"+locationUlId).empty();
                $("#"+locationUlId).css("display","none");
                return false;
            }else if(inputCharCount > 1){
                $.ajax({
                    url: "{{ route('filter.AddLocations') }}",
                    method: "get",
                    data: {
                        value: locationFieldValue
                    },
                    success: function (response) {
                        let locations = response.locations;
                        let locationCount = 0;
                        if(locations.length > 0){

                            locations.forEach(row => {
                                  let location = row.group.location;
                                  if(location.length > 0){
                                       locationCount++;
                                  }
                              });  
                              
                        }
                        if (response.success == true && locationCount > 0) {
                            $("#"+locationUlId).empty();
                            let count = 0;
                            let width = 0;
                        
                            locations.forEach(row => {
                                count++;
                                let location = row.group.location;
                                location.forEach(loc => {
                                    $('#'+locationUlId).append(`<li data-index="${count}"  data-location_id="${loc.id}"  class="location_li">${row.group.name}-${loc.name}</li>`);
                                });
                            });
                            $("#"+locationUlId).css("display", "block");
                            $("#"+locationUlId).css("border", "");
                            width = $("#"+locationFieldId).css("width");
                            $("#"+locationUlId).css("position", "fixed");
                            $("#"+locationUlId).css("width", width);

                        }else if (response.success == false) {

                            $("#"+locationUlId).empty();
                            $("#"+locationUlId).css("border", "");
                            $("#"+locationUlId).css("display", "none");
                            toastr.error(response.msg);
                        }
                    }


                });
            }

        }
    });
</script>