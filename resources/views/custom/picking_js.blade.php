<script>
    /*sale order id*/
    const id = "{{$id}}";
    const baseUrl = "{{URL::to('/')}}";
    let sale_order_part_row_id = "";
    let replaced_short_part_id = "";
    let replaced_part_id = "";
    let actionType = "";
    let partTypeId = "";
    let pickedPartId = "";
    let partCategoryId = "";
    let bag_event_type = "";
    let bag_div_card_id = "";
    /*modal variables*/
    let modalReplaceAction = $("#next-pick-action-modal_replace");
    let modalFulfillAction = $("#next-pick-action-modal_fulfill");
    const behaviourInfo = {
            normal: {
                badge: "badge-primary",
                status: "Active"
            },
            fulfill: {
                badge: "badge-success",
                status: "Fulfill"
            },
            skip: {
                badge: "badge-info",
                status: "skip"
            },
            notfound: {
                badge: "badge-danger",
                status: "Not Found"
            },
            refill: {
                badge: "badge-info",
                status: "Refill"
            },
            replace : {
                badge : "badge-warning",
                status : "Replace"
            }
        };

    const defaultBehaviour = {
        badge: "",
        status: ""
    };
    /*It will load data in view table nextpixk,active and inactive*/
    loadPage(id);
    /*start functions*/

    /*append active parts*/
    const appendActivePart =(activeParts) => {
         // Active Tab Table Updated
         $('#activePartBody').empty();

         $.each(activeParts, function( index, part ) {
            /*check part status*/
             const behaviour = part.is_active == 1 ? behaviourInfo[part.part_behaviour] || defaultBehaviour : defaultBehaviour;
             const partNoLink = `<td><a href="JavaScript:void(0);" class="light-primary" onclick="partsInVirtualPart(${part.id})">${part.part_no}</a></td>`;
             const partNoColumn = part.part.type_id === 556 ? partNoLink : `<td>${part.part_no}</td>`;
            let badge = behaviour.badge;
            let status = behaviour.status;
            /*check part status*/
            $('#activePartBody').append(
                        `<tr data-record_row_id="${part.id}" id="${part.part.id}" data-type_id="${part.part.type_id}" data-category_id="${part.part.category_id}">
                                <td>${index+1}</td>
                                <td><span class="badge ${badge}">${part.is_issued == 1 ? status : "Entered"}</span> </td>
                                <td><img src="${baseUrl}/images/internal100/${part.part_no}/Def/50/50" width="50px" height="50px"></td>
                                ${partNoColumn}
                                <td>${part.part_desc}</td>
                                <td>${part.quantity}</td>
                                <td><span class="${part.quantity > part.oh_inventory ? "text-danger" : ''}">${part.oh_inventory}</span></td>
                                <td>${part.location_names}</td>
                                <td>${part.all_bins}</td>
                                <td>${part.unit_price ?? '--'}</td>
                                <td>${part.unit_price ? part.unit_price * part.quantity : '--'}</td>
                                <td>${
                                    ((part.part.type_id == 108 || part.part.type_id == 556)  && status == "Fulfill") ?  `<a href="#" class="text-gray-400 text-hover-primary me-2 exchange_bags"><i class="fa fa-exchange-alt me-1"></i>Replace Bags</a> <a href="#" class="text-gray-400 text-hover-primary me-2 print_picking_label"><i class="fa fa-print me-1"></i>Print Label</a>` : ''
                                    }
                                    ${status != "Active" ?  `<a href="#" class="text-gray-400 text-hover-danger void_picking_last_action"><i class="fa fa-undo me-1"></i>Void</a>` : ''}
                                    ${!((part.part.type_id == 108 || part.part.type_id == 556) && status == "Fulfill") && status == "Active" ? '--' : ''}
                                </td>
                            </tr>`
                    );

         });
    }

    /*append inActive parts*/
    const appendInActivePart =(inActiveParts) => {

         // Active Tab Table Updated
         $('#inActivePartBody').empty();
         let inactiveBehaviour = {badge:"badge-danger",status:"InActive"};
         $.each(inActiveParts, function( index, part ) {
            let partInfo = behaviourInfo[part.part_behaviour]
            $('#inActivePartBody').append(
                        `<tr data-record_row_id="${part.id}" id="${part.part.id}" data-type_id="${part.part.type_id}" data-category_id="${part.part.category_id}">
                                <td>${index+1}</td> 
                                <td><span class="badge ${partInfo.badge}">${partInfo.status}</span> </td>
                                <td><img src="${baseUrl}/images/internal100/${part.part_no}/Def/50/50" width="50px" height="50px"></td>
                                <td>${part.part_no}</td>
                                <td>${part.part_desc}</td>
                                <td>${part.quantity}</td>
                                <td><span class="${part.quantity > part.oh_inventory ? "text-danger" : ''}">${part.oh_inventory}</span></td>
                                <td>${part.location_names}</td>
                                <td>${part.all_bins}</td>
                                <td>${part.unit_price ?? '--'}</td>
                                <td>${part.unit_price ? part.unit_price * part.quantity : '--'}</td>
                                <td>${status != "Active" ?  `<a href="#" class="text-gray-400 text-hover-danger void_picking_last_action"><i class="fa fa-undo me-1"></i>Void</a>` : '--'}</td>
                            </tr>`
                    );

         });
    }

     /*append inActive parts*/
     const appendNonInventory =(nonInventoryParts) => {
            // Active Tab Table Updated
            $('#nonInventoryPartsTableBody').empty();
            let partBehaviour = "";
            $.each(nonInventoryParts, function( index, part ) {
                partBehaviour = behaviourInfo[part.part_behaviour];
                console.log(partBehaviour.status);
                $('#nonInventoryPartsTableBody').append(
                
                    `<tr data-record_row_id="${part.id}" id="${part.part.id}" data-type_id="${part.part.type_id}" data-category_id="${part.part.category_id}">
                                <td>${index+1}</td> 
                                <td><span class="badge ${partBehaviour.badge}">${part.is_issued == 1 ? partBehaviour.status : "Entered"}</span> </td>
                                <td><img src="${baseUrl}/images/internal100/${part.part_no}/Def/50/50" width="50px" height="50px"></td>
                                <td>${part.part_no}</td>
                                <td>${part.part_desc}</td>
                                <td>${part.quantity}</td>
                                <td>${part.unit_price ?? '--'}</td>
                                <td>${part.unit_price ? part.unit_price * part.quantity : '--'}</td>
                                <td>${(part.is_issued == 1 && partBehaviour.status == "Active") ? 
                                `<a href="#" class="text-gray-400 text-hover-primary fullfill_non_inventory_part me-2">
                                    <i class="fa fa-check me-1"></i>
                                    FulFill</a>
                                    `: 
                                    `${partBehaviour.status == "Fulfill" ? `<a href="#" class="text-gray-400 text-hover-danger void_picking_non_inventory_part"><i class="fa fa-undo me-1"></i>Void</a>` : '--'}`}</td>
                            </tr>`
                    );

            });

    }


    /*append next pick part*/
    const appendNextPickPart = (part) => {
        console.log(part);
        $('.nextPickCard').show();
        // Next Pick Updated
        $('#nextPickPart').empty();
        const partNoLink = `<a href="JavaScript:void(0);" class="light-primary" onclick="partsInVirtualPart(${part.id})">${part.part_no}</a>`;
        const partNoColumn = part.part.type_id === 556 ? partNoLink : part.part_no;
        let partBehaviour = behaviourInfo[part.part_behaviour];
            $('#nextPickPart').append(
                `
                    <tr data-record_row_id="${part.id}" id="${part.part.id}" data-type_id="${part.part.type_id}" data-category_id="${part.part.category_id}">
                        <td style="vertical-align: top;">
                            <div class="symbol symbol-150px border border-gray-400 border-dashed">
                                <div class="symbol-label" style="background-image:url('${baseUrl}/images/internal100/${part.part_no}/Def/50/50')" width="50px" height="50px"></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div>
                                <span class="badge ${partBehaviour.badge} fs-7 mb-2 fw-bold">${partBehaviour.status}</span>
                                <a href="javascript:void(0)" class="text-muted text-hover-primary d-block mb-0 fs-8">Part Number</a>
                                <span class="text-dark fw-bold d-block mb-1 fs-7">${partNoColumn}</span>
                                <a href="javascript:void(0)" class="text-muted text-hover-primary d-block mb-0 fs-8">Part Description</a>
                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.part_desc}</span>
                                <a href="javascript:void(0)" class="text-muted text-hover-primary d-block mb-0 fs-8">Bin</a>
                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.all_bins ?? '--' }</span>
                                <a href="javascript:void(0)" class="text-muted text-hover-primary d-block mb-0 fs-8">Location</a>
                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.location_names}</span>
                            </div>
                        </td>
                        <td style="vertical-align: top;" class="${part.quantity > part.oh_inventory ? "text-danger" : ''}">
                            <div>
                                <span class="text-muted text-hover-primary d-block mb-0 fs-8">Qty on Order</span>
                                <span class="text-dark fw-bold d-block mb-1 fs-7" id="next-pick-qty">${part.quantity}</span>

                                <span class="text-muted text-hover-primary d-block mb-0 fs-8">Qty OH (LG)</span>
                                <span class="text-dark fw-bold d-block mb-1 fs-7 ${part.quantity > part.oh_inventory ? "text-danger" : ''}">${part.oh_inventory ?? '--'}</span>

                                <span class="text-muted text-hover-primary d-block mb-0 fs-8">Unit Price</span>
                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.unit_price ?? '--'}</span>

                                <span class="text-muted text-hover-primary d-block mb-0 fs-8">Subtotal Price</span>
                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.unit_price ? part.unit_price * part.quantity : '--'}</span>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <a href="#" class="text-gray-400 text-hover-primary" id="action__btn__next__pick_fullfill" data-action-type="fulfill">
                                <i class="fa fa-arrow-circle-right"></i> Fulfill
                            </a>&nbsp;
                            <a href="#" class="text-gray-400 text-hover-primary" id="action__btn__next__pick_replace" data-action-type="replace">
                                <i class="fa fa-undo"></i> Replace
                            </a>&nbsp;
                            <a href="#" class="text-gray-400 text-hover-danger notFound" data-bs-toggle="modal" data-bs-target="#updateBehaviourModal" data-not_found_id="${part.id}">
                                <i class="fa fa-exclamation-circle"></i> Not Found
                            </a>&nbsp;
                            <a href="#" class="text-gray-400 text-hover-info skipPart" data-bs-toggle="modal" data-bs-target="#updateBehaviourModal" data-skip_part_id="${part.id}">
                                <i class="fa fa-exclamation-circle"></i> Skip
                            </a>&nbsp;
                            <a href="#" class="text-gray-400 text-hover-primary" id="action__btn__next__pick_refill" data-action-type="refill">
                                <i class="fa fa-undo"></i> Refill
                            </a>
                        </td>
                    </tr>
                `
            );

    }
    /*end functions*/

    $(document).on('click', '.notFound', function () {

        let id = $(this).data('not_found_id');

        $('.updateBehaviourId').val(id);
        $('.showBehaviourType').text('Are you sure Part not Found?');
        $('.updateBehaviourType').val('not found');
    })

    $(document).on('click', '.skipPart', function () {

        let id = $(this).data('skip_part_id');

        $('.updateBehaviourId').val(id);
        $('.showBehaviourType').text('you want to skip this Part?');
        $('.updateBehaviourType').val('skip');
    })

    function updateBehaviour () {

        let id = $('.updateBehaviourId').val();
        let type = $('.updateBehaviourType').val();

        $.ajax({
            type: "get",
            url: "{{ route('saleOrderPicking.updateBehaviour') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
                type: type
            },
            success: function (response) {

                $('#updateBehaviourModal').modal('hide');

                loadPage(response.data.sale_order_id);
                toastr.success('part Updated');

            },

        })
    }

    function loadPage (id) {

        $.ajax({
            type: "get",
            url: "{{ route('saleOrderPicking.loadContent') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
            },
            success: function (response) {
                $('#activePartBody').empty();
                $('#inActivePartBody').empty();
                $('#nonInventoryPartsTableBody').empty();
                // ****************************append active parts***********************************
                if(response.active.active.length > 0){
                    appendActivePart(response.active.active);
                }

                // ****************************append non inventory parts***********************************
                if(response.active.nonInventory.length > 0){
                    appendNonInventory(response.active.nonInventory);
                }

                // ****************************append in active parts***********************************
                if(response.inActive.length > 0){
                    appendInActivePart(response.inActive);
                }


                // ****************************append next pick part***********************************
                if(Object.keys(response.active.nextPick).length > 0){
                    
                    appendNextPickPart(response.active.nextPick);
                    $("#loaderModal").modal("hide");
                }else{
                    $('.nextPickCard').hide();
                    $("#loaderModal").modal("hide");
                }

                // append total 
                $("#in_picking_sale_order_total").text(response.total);
            },
        })
    }
    /*set next pick variables*/
    function setNextPickVariables(thisRow){
        actionType = thisRow.data("action-type");
         /*next to pick record id*/
         const row = thisRow.closest('tr');

        if (row) {
            // get the value of the 'row_id' data attribute
            sale_order_part_row_id = row.data("record_row_id");
            partTypeId = row.data("type_id");
            partCategoryId = row.data("category_id");
            pickedPartId = row.attr("id");
        }else{
            toastr.error("Something went wrong");
            return;
        }
    }

    $(document).on("click","#action__btn__next__pick_fullfill",function(){
        event.preventDefault();
        /*clears the next-pick action modal fields modal fields*/
        setNextPickVariables($(this));
        modalFulfillAction.modal("show");
        freshRefillModal();
        /*fulfill action*/
        if(actionType == "fulfill"){
            fulfillAction();
            bag_event_type = 'refill_bag';
        }

    });

    function freshRefillModal(){

         /*remove fullfilled  bags if exists*/
         $(".picking__div").each(function(index,element){
            if(index != 0){
                $(this).remove();
            }
        });
        // hide fullfill fields
        $("div[class*='fulFill__div__action']").each(function(){
                $(this).find("input,textarea").each(function(){
                    $(this).val("");
                });
                $(this).addClass("d-none");
        });

    }

    // fullfill action
    function fulfillAction(){
        // for fullfill
        $("#qty_on_order").text(`Quantity On Order : ${$("#next-pick-qty").text()}`);
        $(".fulFill__div__action__quantity").removeClass("d-none");
        $(".fulFill__div__action__note ").addClass("d-none");
        $(".pickingQuantity").each(function(){
            $(this).val("");
        });
    }

    // refill confirmation modal
    $(document).on("click","#action__btn__next__pick_refill",function(){
        event.preventDefault();
        setNextPickVariables($(this));
       $("#refill__confirmation__modal").modal("show")
    });
    // refill confirmation
    $(document).on("click","#refill__conifrmation__modal_btn",function(){
        refillAction().then(function(response){
            loadPage(id);
            $("#refill__confirmation__modal").modal("hide");
            toastr.success("Part sent to refill successfully");
        })
        .catch((value) => {
            toastr.error("Something went wrong");
            $("#refill__confirmation__modal").modal("hide");
        });
    });
    //refill call
    function refillAction(){

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.refill')}}",
                type: 'POST',
                data:{
                    action_type : actionType,
                    pick_record_id : sale_order_part_row_id,
                },
                beforeSend: function () {},
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }

    // replace modal
    $(document).on("click","#action__btn__next__pick_replace",function(){
        event.preventDefault();
        setNextPickVariables($(this));
        modalReplaceAction.modal("show");
        replaceAction().then(function(response){

             const { success,...parts } = response;

             if(success == true){

                if(parts.parts.length){
                    $("#replaceableSuggestedParts").empty();
                    $.each(parts.parts, function( index, part ) {
                        $("#replaceableSuggestedParts").append(`
                            <tr class="replaceable_row" data-replaced_part_id="${part.id}">
                                <td>${index+1}</td>
                                <td><img src="${baseUrl}/images/internal100/${part.part_no}/Def/50/50" width="50px" height="50px"></td>
                                <td>${part.part_no}</td>
                                <td>${part.desc}</td>
                                <td>${part.category.name_in_english}</td>
                                <td>${part.available_inventory}</td>
                            </tr>
                        `);
                    });

                }

             }else{
                $("#replaceableSuggestedParts").empty();
                $("#replaceableSuggestedParts").append(`<tr>No part found</tr>`);
             }
            //  modalReplaceAction.modal("hide");
        })
        .catch((value) => {
            console.log('Something went wrong');
            //  modalReplaceAction.modal("hide");
        });
    });

    //replace confirmation
    $(document).on("click","#next-pick-action-confirmation-btn-replace",function(){
        event.preventDefault();
        let dataObject = {};
        /*validate inventory part*/
        if(!$("#replaced_quantity_amount").val()){
            toastr.error("Provide quantity to replace");
            return;
        }
        if(partTypeId == "108" || partCategoryId == "558"){
            if(checkInventoryQuantity() == true){
                dataObject.sale_order_part_row_id = sale_order_part_row_id,
                dataObject.replaced_quantity = parseInt($("#replaced_quantity_amount").val()),
                dataObject.note = $("#replaced_quantity_note_textarea").val(),
                dataObject.old_part_id = pickedPartId,
                dataObject.new_part_id = replaced_part_id,
                dataObject.type_id = partTypeId,
                dataObject.category_id = partCategoryId
            }else{
                return false;
            }
        }
        replacePart(dataObject)
            .then((response)=>{
                $("#replaced_quantity_amount").val("");
                $("#loaderModal").modal("hide");
                $("#next-pick-replace-quantity-modal").modal("hide");
                $("#next-pick-action-modal_replace").modal("hide");
                loadPage(id);
            })
            .catch((error)=>{
                $("#replaced_quantity_amount").val("");
                toastr.error("Something went wrong");
                $("#next-pick-replace-quantity-modal").modal("hide");
                $("#next-pick-action-modal_replace").modal("hide");
                $("#loaderModal").modal("hide");
                loadPage(id);
            });

    });
    /*replace input field */
    // $("input#replaced_quantity").keydown(function(){

    // });
    //replace action
    function replaceAction(){

         return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.replace')}}",
                type: 'POST',
                data:{
                    action_type : actionType,
                    pick_record_id : sale_order_part_row_id,
                    type_id : partTypeId,
                    part_id : pickedPartId
                },
                beforeSend: function () {},
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }
     /*replace part*/
     function replacePart(dataObject){
       
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.replacePart')}}",
                type: 'POST',
                data:dataObject,
                beforeSend: function () {
                    $("#loaderModal").modal("show");
                },
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });

     }
    /*print labels*/
     $(document).on("click",".print_picking_label",function(){
        event.preventDefault();
        setNextPickVariables($(this));
        /*next to pick record id*/


         if (sale_order_part_row_id) {
             // get the value of the 'row_id' data attribute
             printLabel( sale_order_part_row_id).then(function(response){
                 var printWindow  = window.open('', "_blank", "width=800,height=700");
                 var is_chrome = Boolean(printWindow.chrome);
                 printWindow .document.write(response);
                 // add CSS for A4 size
                 if (is_chrome) {
                     setTimeout(function () { // wait until all resources loaded
                         printWindow .document.close(); // necessary for IE >= 10
                         printWindow .focus(); // necessary for IE >= 10
                         printWindow .print(); // change window to winPrint
                         printWindow .close(); // change window to winPrint
                     }, 1000);
                 } else {
                     printWindow .document.close(); // necessary for IE >= 10
                     printWindow .focus(); // necessary for IE >= 10
                     printWindow .print();
                     printWindow .close();
                 }
             })
                 .catch((value) => {
                     console.log('Something went wrong');
                 });
         }else{
             toastr.error("Something went wrong");
             return;
        }
    });
     //

     //print label
     function printLabel(sale_order_part_id){
       return new Promise((resolve, reject) => {
          $.ajax({
              url: "{{route('saleOrderPicking.ptintLabel')}}",
              type: 'POST',
              data:{
                sale_order_part_id
              },
              beforeSend: function () {},
              success: function (data) {
                  resolve(data)
              },
              error: function (error) {
                  reject(error)
              }
          });
      });
  }


    //   on confirmation button
    $(bag_div_card_id+" #next-pick-action-confirmation-btn-fulfill").click(()=>{
        /*if quantity is greater than the on order return*/
       
        setBagType();
        if(checkIsBagEmpty() == 1){
            toastr.error("Please provide quantity in bag to continue");
            return;
        }
        let totalQuantity = totalQuantityPicked();
        
       
        if(totalQuantity > parseInt($(bag_div_card_id+" #qty_on_order").text().split(":")[1].trim())){
            toastr.error("Fulfilled quantity not be greater than on order");
            return;
        }
        let data = {};
        
        
        data.type = actionType;
        let fullFilledQuantity = totalQuantity;
        if(!fullFilledQuantity){
            toastr.error("Please fill quantity");
            return;
        }
       
        let bags = [];
        $(bag_div_card_id+" .pickingQuantity").each(function(){
                bags.push($(this).val());
            });
        /*on save fullfill action*/
       
        if(actionType == "fulfill"){
           

            data.bags = bags;
            if(fullFilledQuantity && fullFilledQuantity < parseInt($("#next-pick-qty").text())){
                $(bag_div_card_id+" .fulFill__div__action__note ").removeClass("d-none");
            }else{
                $(bag_div_card_id+" #part__action__note").val("");
                $(bag_div_card_id+" .fulFill__div__action__note ").addClass("d-none");
            }

            data.quantity = (fullFilledQuantity);
            if(parseInt(fullFilledQuantity) < parseInt($("#next-pick-qty").text())){
                if(!$(bag_div_card_id+" #part__action__note").val()){
                    toastr.error("Please provide notes");
                    return;
                }
                data.note = $(bag_div_card_id+" #part__action__note").val();
            }
            $("#loaderModal").modal("show");
            data = {sale_order_part_row_id:sale_order_part_row_id,...data};
            checkQuantityExist({"sale_order_part_row_id":data.sale_order_part_row_id,"quantity":data.quantity}).then((response)=>{
                if(response.success == 0){
                    toastr.error(response.msg);
                    return;
                }else if(response.success == 1){
                    /*IF QUANTITY EXISTS THEN GO FOR DEDUCTION*/
                     updatePickingPart(data).then((response) => {
                            if(response.success == false){
                                toastr.error(response.msg);
                                return;
                            }else if(response.success == true){
                                toastr.success(response.msg);
                                loadPage(response.sale_order_id);
                            }
                            modalFulfillAction.modal("hide");
                            $("#loaderModal").modal("hide");
                        }).catch((error) => {
                            toastr.error("Something went wrong");
                            modalFulfillAction.modal("hide");
                            $("#loaderModal").modal("hide");
                        });
                }
            }).catch((error)=>{
                alert("Something went wrong");
                $("#loaderModal").modal("hide");
                return;
            });


        }else if(bag_div_card_id = "#fulfillBagsCard"){
            let replacedBag = {};
            setBagType();
            
          
            let qtyOnOrder = parseInt($(bag_div_card_id+" #qty_on_order").text().split(":")[1].trim());
            if(qtyOnOrder != fullFilledQuantity){
                toastr.error("Quantity on order must be fulfilled");
                return;
            }
            replacedBag.sale_order_part_row_id = sale_order_part_row_id;
            replacedBag.bags = bags;
            // if(fullFilledQuantity && fullFilledQuantity < qtyOnOrder){
            //     $(bag_div_card_id+" .fulFill__div__action__note ").removeClass("d-none");
            // }else{
            //     $(bag_div_card_id+" #part__action__note").val("");
            //     $(bag_div_card_id+" .fulFill__div__action__note ").addClass("d-none");
            // }

            replacedBag.quantity = (fullFilledQuantity);
            // if(parseInt(fullFilledQuantity) < qtyOnOrder){
            //     if(!$(bag_div_card_id+" #part__action__note").val()){
            //         toastr.error("Please provide notes");
            //         return;
            //     }else{
            //         replacedBag.note = $(bag_div_card_id+" #part__action__note").val();
            //     }
            // }else{
            //     replacedBag.note = "";
            // }
            replaceBags(replacedBag)
            .then((response) => {
                if(response.success == true){
                    $("#replace__bags_fulfill_modal").modal("hide");
                    toastr.success("Bags updated successfully");
                }
                $("#loaderModal").modal("hide");
            })
            .catch((value) => {
                toastr.error("Something went wrong");
                $("#loaderModal").modal("hide");
            });
        }



    });

    // set picking action
    function updatePickingPart(data){

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.fulfillAction')}}",
                type: 'POST',
                data:data,
                beforeSend: function () {},
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }

    /*total quantity from picking action after modal is open*/
    function checkIsBagEmpty(){
        setBagType();
            let isBagEmpty = 0;
           
            $(bag_div_card_id+" .pickingQuantity").each(function(index,val){
                var quantity = parseInt($(this).val());
               
                if(!quantity) {
                   
                    isBagEmpty = 1;
                }
            });
           
            return isBagEmpty;
    }

    function totalQuantityPicked(){
        setBagType();
        let totalQuantity = 0;
        
            $(bag_div_card_id+" .pickingQuantity").each(function(){
                var quantity = parseInt($(this).val());
                if(quantity) {
                    totalQuantity += parseInt(quantity);
                }
            });
             return totalQuantity;
            
    }
    /*add new new row for quantity*/
    $(document).on("click",".add_picking_bag",function(){
      
        let divClass = "";
        
        setBagType();
       
        let currentQty = true;
        $(bag_div_card_id+" .pickingQuantity").each(function(){
            if(!$(this).val()){
                currentQty = false;
                return false;
            }
        });


        if(!currentQty){
            toastr.error("Please fill current bag value to continue");
            return;
        }
        let currentDiv = $(this).closest(bag_div_card_id+" .picking__div");
        let bagNum = $(bag_div_card_id+" .picking__div").length+1;
        let div = `
        <div class="form-group row picking__div mb-2" data-bag="${bagNum}">
                            <label for="inputField" class="col-sm-2 required form-label col-form-label">Bag ${bagNum}</label>
                            <div class="col-sm-8">
                              <input type="number"  class="form-control mb-w pickingQuantity" placeholder="Quantity">
                            </div>
                            <div class="col-sm-2 mt-4">
                              <a type="button" class="add_picking_bag text-hover-primary text-gray-400" >
                                <span class="fas fa fa-plus"></span>
                              </a>
                              <a type="button" class="remove_picking_bag text-hover-danger ms-2 text-gray-400" >
                                <span class="fas fa fa-trash"></span>
                              </a>
                            </div>
        </div>`;
        let lastElement = $(".picking__div").last();
        lastElement.after(div);

    });
    /*Remove current row and rearrange bage names*/
    $(document).on("click",".remove_picking_bag",function(){
        let currentDiv = $(this).closest(bag_div_card_id+" .picking__div");
        currentDiv.remove();
        $(bag_div_card_id+" .picking__div").each(function(index,element){
            $(this).data("bag",index+1);
            $(this).find("label").text(`Bag ${index+1}`)
        });
    });

    /*check part quantity exist or not*/
    function checkQuantityExist(dataObject){

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.checkQuantity')}}",
                type: 'POST',
                data:dataObject,
                beforeSend: function () {},
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }
    /*undo modal display*/
    $(document).on("click",".void_picking_last_action",function(){
        event.preventDefault();
        setNextPickVariables($(this));
        $("#void__confirmation__modal").modal("show");
    });
    /*confirmation void*/
    $("#void__conifrmation__modal_btn").click(function(){
        
        voidInventoryAndSpecialParts()
        .then((response) => {
            if(response.success == true){
                toastr.success("Part action void succeefully");
            }else{
                toastr.error("Something went wrong");
                return;
            }
            $("#void__confirmation__modal").modal("hide");
            
          loadPage(id);



        })
        .catch((error) => {
            toastr.error("Something went wrong");
        });
        //${sale_order_part_row_id}
    });

    /*void inventory and special parts*/
    function voidInventoryAndSpecialParts(){

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{route('saleOrderPicking.voidInventoryAndSpecialParts')}}",
                    type: 'POST',
                    data:{sale_order_part_row_id},
                    beforeSend: function () {},
                    success: function (data) {
                        resolve(data)
                    },
                    error: function (error) {
                        reject(error)
                    }
                });
            });
    }


    

    /*replaced part id*/
    $(document).on("click",".replaceable_row",function(){
        replaced_part_id = $(this).closest("tr").data("replaced_part_id");
       
         /**
          * ** storing to check either it is inventory,virtual (special,kit) or non-inventory
          * inventory (type_id = 108)
          * virtual (type_id = 556) (category_id == 557 special) (category_id == 558 kit)
          * all others are non-inventory
         */
        if(partTypeId == "108" || partCategoryId == "558"){

            $("#replaced_quantity_note_div").addClass("d-none");
            $("#replaced_quantity_note_textarea").val("");
            $("#pick_qty_on_order").text(`Quantity on order : ${$("#next-pick-qty").text()}`);
            $("#next-pick-replace-quantity-modal").modal("show");

        }else if(partCategoryId == "557"){
                /*get short parts of virtual part*/
            getVirtualShortSubParts().then((response) => {
               
                if(response.short_parts.length != 0){
                    let count = 0;
                    $("#next-pick-action-modal_short_parts").modal("show");
                    $("#replaceableVirtualSuggestedShortParts").empty();
                    $.each(response.short_parts, function( index, part ) {
                      
                        $("#replaceableVirtualSuggestedShortParts").append(`
                            <tr class="selected_short_part" data-sub_part_id="${part.id}">
                                <td>${count+1}</td>
                                <td><img src="${baseUrl}/images/internal100/${part.part_no}/Def/50/50" width="50px" height="50px"></td>
                                <td>${part.part_no}</td>
                                <td>${part.part_desc}</td>
                                <td>${part.part.category.name_in_english}</td>
                                <td>${part.order_quantity}</td>
                                <td>${part.available_inventory}</td>
                            </tr>
                        `);
                    });
                }else{
                    toastr.error("No short part available");
                }
            }).catch((error) => {
                console.log('error',error);
                toastr.error("Something went wrong");
            });
        }
      

    });

   /*
   Quantity to be replaced 
   */
  $(document).on("keyup","#replaced_quantity_amount",function(){
   
     checkInventoryQuantity();

  });


  function checkInventoryQuantity(){

    let noteDiv = $("#replaced_quantity_note_div");
    let noteTextArea = $("#replaced_quantity_note_textarea");
    let replacedQuantity = parseInt($("#replaced_quantity_amount").val());
    let partToBeReplacedQuantity = parseInt($("#next-pick-qty").text());
  
    if(replacedQuantity < partToBeReplacedQuantity){
   
        noteDiv.removeClass("d-none");

        if(!noteTextArea.val()){
            toastr.error("Please provide note for less quantity");
            return false;
        }
        return true;
   
    }else if(replacedQuantity > partToBeReplacedQuantity){
   
       noteDiv.addClass("d-none");
       toastr.error("Quantity should not be greater than the previous part");
       return false;

    }else{

        noteTextArea.val("");
        noteDiv.addClass("d-none");
        return true;
    }   

  }


   /*get short parts inside vitual parts*/
   function getVirtualShortSubParts(){

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.getShortParts')}}",
                type: 'POST',
                data:{
                    sale_order_part_row_id
                },
                beforeSend: function () {},
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }

    /*replace virtual short part*/
    $(document).on("click",".selected_short_part",function(){
        replaced_short_part_id =  $(this).data("sub_part_id");
        $("#replace__special__confirmation__modal").modal("show");
    });
    
    /*replace confirmation button*/
    $(document).on("click","#replace__special__confirmation__btn",function(){
        confirmSpecialPartReplacement();
    });
    
    function confirmSpecialPartReplacement(){
        let dataObject = {};
        if(partCategoryId == "557"){
            dataObject.replaced_short_part_id = replaced_short_part_id;
            dataObject.type_id = partTypeId;
            dataObject.category_id = partCategoryId;
            dataObject.replaced_part_id = replaced_part_id;
            dataObject.sale_order_part_row_id = sale_order_part_row_id;
        }

        replacePart(dataObject).then((response) => {
            toastr.success("Short part replaced successfully");
            $("#loaderModal").modal("hide");
            $("#replace__special__confirmation__modal").modal("hide");
            $("#next-pick-action-modal_replace").modal("hide");
            $("#next-pick-action-modal_short_parts").modal("hide");
            $("#next-pick-replace-quantity-modal").modal("hide");    
            loadPage(id);   
        })
        .catch((error) => {
            $("#loaderModal").modal("hide");
            toastr.error("Something went wrong");
            // $("#next-pick-replace-quantity-modal").modal("hide");    
        });
        
    }

    /*fullfill or complete non inventory part*/

    $(document).on("click",".fullfill_non_inventory_part",function(){
        setNextPickVariables($(this));
        $("#fulfill__noninventory__confirmation__modal").modal("show");
       
    });

    $(document).on("click","#fulfill__noninventory__confirmation__modal_btn",function(){
        completeNonInventoryPart()
        .then((response) => {
            if(response.success == true){
                toastr.success("Service completed successfully");
                loadPage(id);
            }else{
                toastr.error("Something went wrong");
            }
            $("#loaderModal").modal("hide");
            $("#fulfill__noninventory__confirmation__modal").modal("hide");
        })
        .catch((error) => {
            toastr.error("Something went wrong");
            $("#loaderModal").modal("hide");
        });
    });
    /*function to fulfill non inventory part*/
    function completeNonInventoryPart(){

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.completeNonInventoryPart')}}",
                type: 'POST',
                data:{
                    sale_order_part_row_id
                },
                beforeSend: function () {
                    $("#loaderModal").modal("show");
                },
                success: function (data) {
                    
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }
    /*fullfill or complete non inventory part*/

    $(document).on("click",".void_picking_non_inventory_part",function(){
        setNextPickVariables($(this));
        $("#void__confimarion__non__inventorymodal").modal("show");
       
    });

    $(document).on("click","#void__confimarion__non__inventorymodal__btn",function(){
        voidNonInventoryPart()
        .then((response) => {
            if(response.success == true){
                toastr.success("Part void successfully");
                loadPage(id);
            }else{
                toastr.error("Something went wrong");
            }
            $("#loaderModal").modal("hide");
            $("#void__confimarion__non__inventorymodal").modal("hide");
        })
        .catch((error) => {
            toastr.error("Something went wrong");
            $("#loaderModal").modal("hide");
        });
    });
    /*function to fulfill non inventory part*/
    function voidNonInventoryPart(){

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.viodNonInventoryPart')}}",
                type: 'POST',
                data:{
                    sale_order_part_row_id
                },
                beforeSend: function () {
                    $("#loaderModal").modal("show");
                },
                success: function (data) {
                    
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }

    /*replace bags*/
    $(document).on("click",".exchange_bags",function(){
        actionType = "";
        let mainDiv = $("#replaceBagsCard");
        mainDiv.children().not("#qty_on_order").remove();
        $("#replace__bags_fulfill_modal").modal("show");
        sale_order_part_row_id = $(this).closest('tr').data("record_row_id");  
        bag_event_type = "replace_bag";
        setBagType();
        fetchBagDetials()
        .then((response) => {
            $("#replaceBagsCard #qty_on_order").text('');
            $("#replaceBagsCard #qty_on_order").text(`Quantity On Order : ${response.quantity}`);
            $.each(response.bags, function( index, bag ) {
                let bagNum = $("div.picking__div").length+1;
                let div = `
                <div class="form-group row picking__div mb-2" data-bag="${bag.bag_number}">
                                    <label for="inputField" class="col-sm-2 required form-label col-form-label">Bag ${bag.bag_number}</label>
                                    <div class="col-sm-8">
                                    <input type="number"  class="form-control mb-w pickingQuantity" value="${bag.quantity}" placeholder="Quantity">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                    <a type="button" class="add_picking_bag text-hover-primary text-gray-400" >
                                        <span class="fas fa fa-plus"></span>
                                    </a>
                                    ${index !=0 ? '<a type="button" class="remove_picking_bag text-hover-danger ms-2 text-gray-400" ><span class="fas fa fa-trash"></span></a>' : ''}
                                    </div>
                </div>`;
               
                mainDiv.append(div);
            });
            $("#loaderModal").modal('hide');
        })
        .catch((error) => {
            console.log(error);
            toastr.error("Something went wrong");
        });
    });


    /*fetch bags details*/
    function fetchBagDetials(){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.fetchBagDetails')}}",
                type: 'POST',
                data:{
                    sale_order_part_row_id
                },
                beforeSend: function () {
                    $("#loaderModal").modal("show");
                },
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }

    function setBagType(){
       
        if(bag_event_type == "replace_bag"){
            bag_div_card_id = "#replaceBagsCard";
        }else if(bag_event_type == "fulfill_bag"){
            bag_div_card_id = "#fulfillBagsCard";
        }
    }

    function replaceBags(data){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{route('saleOrderPicking.updateBagDetails')}}",
                type: 'POST',
                data:data,
                beforeSend: function () {
                    $("#loaderModal").modal("show");
                },
                success: function (data) {
                    resolve(data)
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    }
</script>
