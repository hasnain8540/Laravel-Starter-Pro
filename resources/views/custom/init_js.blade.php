<script>
      $('.searchable-dropdown').select2({
            // placeholder: "Select Option"
      });
    // Parse Module Id to Module Destroy Modal
    $('.destroyModule').on('click', function () {

        let module_id = $(this).data('module_id');

        $('#destroyModuleId').val(module_id);
    });
    // Parse permission Id to Pemrission destroy Modal
    $('.destroyPermission').on('click', function () {

        let permission_id = $(this).data('permissison_id');

        $('#PermissionId').val(permission_id);
    });
    // Parse Role Id to Role Destroy Modal
    $('.destroyRole').on('click', function () {

        let role_id = $(this).data('role_id');

        $('#roleId').val(role_id);
    });
    // Parse user id to User Destroy Modal
    $('.destroyUser').on('click', function () {

        let user_id = $(this).data('user_id');

        $('#userId').val(user_id);
    });
    // Parse Vendor id to Vendor activate Modal
    $('.activateVendor').on('click', function () {

    let vendor_id = $(this).data('vendor_id');

    $('#activateVendorId').val(vendor_id);
    });
    // Parse Vendor id to Vendor Inactivate Modal
    $('.inactivateVendor').on('click', function () {

    let vendor_id = $(this).data('vendor_id');

    $('#inactivateVendorId').val(vendor_id);
    });
    // Parse Vendor id to Vendor Destroy Modal
    $('.destroyVendor').on('click', function () {

        let vendor_id = $(this).data('vendor_id');

        $('#destroyVendorId').val(vendor_id);
    });
    // Parse Field id to add Option Modal
    $('.newOption').on('click', function () {

        let field_id = $(this).data('field_id');

        $('#fieldId').val(field_id);
    });
    // parse Data to Edit Option Modal
    $('.editOption').on('click', function () {

        let id = $(this).data('option_id');
        let status = $(this).data('option_status');
        let english = $(this).data('option_english');
        let spanish = $(this).data('option_spanish');
        let portuguese = $(this).data('option_portuguese');
        let chinese = $(this).data('option_chinese');

        $('#field_id').val(id);
        $('#edit_status').val(status);
        $('#edit_name_in_english').val(english);
        $('#edit_name_in_spanish').val(spanish);
        $('#edit_name_in_portuguese').val(portuguese);
        $('#edit_name_in_chinese').val(chinese);
    });
    // Parse Data to Destroy Sub Field
    $('.destroySubField').on('click', function () {

        let subField_id = $(this).data('field_id');

        $('#destroySubFieldId').val(subField_id);
    });
    // Parse Delete Field Id to destroy modal
    $('.destroyField').on('click', function () {

        let field_id = $(this).data('del_field_id');

        $('#delField_id').val(field_id);
    });
    // Parse Upc Id into destroy Modal
    $('.destroyUpc').on('click', function () {

        let upc_id = $(this).data('upc_id');

        $('#destroyUpcId').val(upc_id);
    });
    // Parse Bin Id into destroy Modal
    $('.destroyBin').on('click', function () {

        let bin_id = $(this).data('bin_id');

        $('#destroyBinId').val(bin_id);
    });
    // Parse Shopify Account Id into destroy Modal
    $('.destroyShopifyAccount').on('click', function () {

        let account_id = $(this).data('shopify_account_id');

        $('#destroyShopifyId').val(account_id);
    });
//  upc no field characters minimum 13
    $('#upc_no').on('focusout', function() {
            let upc_no = $(this).val();
            let lengthCount=(upc_no.trim()).length;
            if(lengthCount < 13) {
                $(this).siblings('.text-danger').text('Upc No must be 13 digits current '+lengthCount+' digits').removeClass('d-none');
                $(".upc_action_button").attr("disabled", 'true');
            }else{
                $(this).siblings('.text-danger').text('').addClass('d-none');
                $(".upc_action_button").removeAttr("disabled");
            }
    });

    // Parse Detach Id to User Detach to Location Group Modal
    $('.detachUserToLocation').on('click', function () {

        let detach_location_id = $(this).data('detach_location_id');
        let detach_user_id = $(this).data('detach_user_id');

        $('#detach_user_id').val(detach_user_id);
        $('#detach_location_id').val(detach_location_id);
    });

    // Parse Location ID to Attach User Modal
    $('.attachUser').on('click', function () {

        let location_id = $(this).data('location_id');

        $('#location_id').val(location_id);
    });

    // Location Group Append in User Form
    $('#location').on('change', function() {
        var optionSelected = $(this).find("option:selected");
        let location = optionSelected.val();

        if ($('.locationArray').val()) {
            var count = 0;
            $('.locationArray').map(function () {
                if ($(this).val() == location) {
                    count++;
                }
            });

            if (count > 0) {
                return false;
            }
        }

        $.ajax({
            type: "get",
            url: "{{ route('user.getLocation') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                location: location
            },
            success:function(response) {
                if (response.success) {

                    let table = document.getElementById("locationRow");
                    let tbodyRowCount = table.rows.length + 1;

                    $('#location').val('').trigger('change');

                    let defaultRow = (tbodyRowCount == 1) ? '<span class="badge badge-info">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="defaultCheck" name="defaultCheck[]">' : '';

                    let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefaultLocation" onclick="changeDefaultLocation('+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> </button>' : '' ;

                    $('#locationRow').append(
                        `
                            <tr>
                                <td style="text-align: center">`+ tbodyRowCount +`</td>
                                <td>
                                    `+ response.detail.name +`
                                    <input type="hidden" value="`+response.detail.id+`" data-name="`+response.detail.name+`" name="locationArray[]" class="locationArray">
                                    <input type="hidden" value="`+response.detail.name+`" name="locationNameArray[]" class="locationNameArray">
                                </td>
                                <td>`+ defaultRow +`</td>
                                <td>`+ changeDefault +`<button type="button" class=" remLocation" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> </button> </td>
                            </tr>
                        `
                    );
                }
            }
        })
    });

    // Remove Gender Rows
    $("#locationRow").on('click', '.remLocation', function () {
        $(this).parent().parent().remove();
    });


    // Change Default location in User Form
    function changeDefaultLocation(index) {

        let location = [];
        let defaultLocation = [];

        $('.locationArray').map(function (looop) {
            looop = looop + 1;

            if(looop == index) {

                defaultLocation.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                });
            } else {

                location.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                });
            }
        });

        $('#locationRow').empty();

        let serial = 1;

        $('#locationRow').append(
            `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ defaultLocation[0].name +`
                        <input type="hidden" value="`+defaultLocation[0].id+`" data-name="`+defaultLocation[0].name+`" name="locationArray[]" class="locationArray">
                        <input type="hidden" value="`+defaultLocation[0].name+`" name="locationNameArray[]" class="locationNameArray">
                    </td>
                    <td><span class="badge badge-info">Default</span><input type="hidden" value="`+ serial +`" id="defaultCheck" name="defaultCheck[]"></td>
                    <td><button type="button" class=" remLocation" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> </button></td>
                </tr>
            `
        );

        serial++;

        for (let s = 0; s < location.length; s++) {
            $('#locationRow').append(
                `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ location[s].name +`
                        <input type="hidden" value="`+location[s].id+`" data-name="`+location[s].name+`" name="locationArray[]" class="locationArray">
                        <input type="hidden" value="`+location[s].name+`" name="locationNameArray[]" class="locationNameArray">
                    </td>
                    <td></td>
                    <td><button type="button" style="background: transparent; border: none" class="changeDefault" onclick="changeDefaultLocation(`+ serial +`)"><i class="fa fa-arrow-circle-up"></i> </button><button type="button" class=" remLocation" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> </button> </td>
                </tr>
            `
            );
            serial++;
        }
    }

    // Parse Part Id into destroy Modal
    $('.destroyPart').on('click', function () {

        let destroyPartId = $(this).data('destroy_part');

        $('#destroyPartId').val(destroyPartId);
    });

    // Check Storage button
    function checkdropboxBtn() {

        if ( document.getElementById("dropbox").checked = true) {

            document.getElementById("s3_bucket").checked = false;
        } else {
            document.getElementById("s3_bucket").checked = true;
        }
    }

    function checks3bucketBtn() {

        if ( document.getElementById("s3_bucket").checked = true) {

            document.getElementById("dropbox").checked = false;
        } else {
            document.getElementById("dropbox").checked = true;
        }
    }

    // Parse Part Id into destroy Modal
    $('.destroyPoolCategory').on('click', function () {

        let destroyPartId = $(this).data('pool_category_id');

        $('#destroyPoolCategoryId').val(destroyPartId);
    });
    //select all
    $('.check-all').on('click', function (e) {
        var table = $(e.target).closest('table');
        $('td input:checkbox', table).prop('checked', this.checked);
        if ($(this).prop("checked") == true) {
            $('.selected').removeClass('d-none');
            $('.create-btn').hide();
            let checkboxCount = $('td input:checkbox:checked', table).length
            $('.selected_count').text(checkboxCount + ' Selected')
        } else if ($(this).prop("checked") == false) {
            $('.selected').addClass('d-none');
            $('.create-btn').show();


        }
    })
    $('.check').on('click', function (e) {
        var table = $(e.target).closest('table');
        if ($(this).prop("checked") == true) {
            $('.selected').removeClass('d-none');
            $('.create-btn').hide();
            let checkboxCount = $('td input:checkbox:checked', table).length
            $('.selected_count').text(checkboxCount + ' Selected')
            if ($('td input:checkbox', table).length == checkboxCount) {
                $('.check-all').prop('checked', this.checked)
            }
        } else {
            let checkboxCount = $('td input:checkbox:checked', table).length
            $('.selected_count').text(checkboxCount + ' Selected')
            $('.check-all').prop('checked', this.checked)
            if (checkboxCount == 0) {
                $('.selected').addClass('d-none');
                $('.create-btn').show();
            }

        }
    })
      $('.deleteMultiple').on('click', function (e) {
          $('#destroySelectedUser').modal('show');
          var checkedbox = $('td input:checkbox').prop('checked', this.checked)
          let idArray = [];
          for (var i = 0; i < checkedbox.length; i++) {
              if (checkedbox[i].checked == true) {
                  idArray.push(checkedbox[i].value)
              }
          }
          console.log(idArray)
          $('#userIds').val(idArray);

      })

      // Detach user Role
      $('.detachUserRole').on('click', function () {

          let detachUserId = $(this).data('user_id');
          let detachRoleId = $(this).data('role_id');

          $('#detachUserId').val(detachUserId);
          $('#detachRoleId').val(detachRoleId);
      });

      // Delete Location Group
      $('.destroyLocationGroup').on('click', function () {

          let location_group = $(this).data('location_group');

          $('#destroyLocationGroupId').val(location_group);
      });

      // Delete Location
      $('.destroyLocation').on('click', function () {

          let location_id = $(this).data('location_id');

          $('#location_ids').val(location_id);
      });

      // Delete Location
      $('.destroyCurrency').on('click', function () {

          let currency_id = $(this).data('currency_id');

          $('#currency_ids').val(currency_id);
      });

      //coonect google contact api
      $('#addGoogleAccount').on('click', function () {
          let clientId = $('#googleClientId').val();
          let secretKey = $('#googleSecretId').val();
          let googleApiKey = $('#googleApiKey').val();
          if (clientId != null && secretKey != null) {
              $.ajax({
                  type: "post",
                  url: "{{ route('customer.addNewApiDetails') }}",
                  data: {
                      "_token": "{{ csrf_token() }}",
                      secretKey: secretKey,
                      clientId: clientId,
                      googleApiKey
                  },
                  dataType: 'json',
                  success: function (response) {
                      let url = "{{ route('customer.google.auth')}}";
//                     window.open(url, '_blank');
                      window.open(url, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
                  }
              })
          } else {
              toastr.error('Enter Clint Id or Secret id ')
          }
      })
</script>
