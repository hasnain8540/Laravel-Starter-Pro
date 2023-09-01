<script>
     function metalStampOnBaseMaterial(base_material_id){
        $("#metal_stamp_id").empty();
       $.ajax({
        method: "get",
        url: "{{ route('base.metal') }}",
            data: {
                base_material_id : base_material_id
            },
            success:function(response){
                if(response.success == 'true'){
                    let materials=response.baseMaterial;
                    $("#metal_stamp_id").append('<option value="" >Select an option</option>');
                        materials.forEach(material => {  
                        $("#metal_stamp_id").append('<option value="'+material.metals[0].id+'" >'+material.metals[0].name_in_english+'</option>');        
                        });
                    $("#metal_stamp_id").attr("required", true);
                }else{
                    $("#metal_stamp_id").attr("required", false);
                }
            }
       });
    }
</script>