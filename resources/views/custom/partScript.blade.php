<script>

    // on first focus (bubbles up to document), open the menu
    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

    // steal focus during close - only capture once and stop propogation
    $('select.select2').on('select2:closing', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
        });
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $(document).ready(function () {
        // Load Base Logics
        base();
        // After Loading Base Data Hide Loader
        $('.loader').hide();
        // and show Content
        $('.content').fadeIn('slow');

        // Get all DropDowns Data
        getDropdownData();

        // Initialize Select2
        $('.dropdown').select2({
            placeholder: "Select Option"
        });

        @if (Route::is('part.duplicate'))
            loadPartData();
        @endif
    });

    function base()
    {
        let index = $('#Index').val();
        let part = $('#part_id').val();
        let creationPart = $('#CreationType').val();

        $.ajax({
            type: "get",
            url: "{{ route('part.baseLoad') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'index': index,
                'part': part,
                'creationPart': creationPart
            },
            success:function(response) {
                if (response.success) {

                    $('#CreationType').val(response.creationType);
                    if (response.part) {

                        $('#vendor_id').val(response.part.vendor_id);
                    }
                    // Set Title and Index
                    // Set ProgressBar
                    let width = '';
                    if (response.creationType == 'create') {

                        $('#title').html(response.title+' ( '+response.index+'/10 )');

                        width = (response.index/10)*100;
                    } else {
                        $('.page-title').empty();
                        $('.page-title').append(
                            `
                                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Virtual Part</h1>
                                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
                                   <li class="breadcrumb-item text-muted"><a href="/" class="text-muted text-hover-primary">Home</a></li>
                                   <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-350 w-5px h-2px"></span>
                                   </li>
                                   <li class="breadcrumb-item text-muted">Materials</li>
                                   <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-350 w-5px h-2px"></span>
                                   </li>
                                   <li class="breadcrumb-item text-muted"><a href="{{ route('new.part.dashboard') }}" class="text-muted text-hover-primary">Virtual Parts</a></li>
                                   <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-350 w-5px h-2px"></span>
                                   </li>
                                   <li class="breadcrumb-item text-dark">New Part</li>
                                </ul>
                            `
                        );
                        $('#title').html(response.title+' ( '+response.index+'/4 )');

                        width = (response.index/3)*100;
                    }
                    document.getElementById("progressBar").style.width = width+"%";

                    // show Part Step in Form
                    if (response.index == '0' && response.creationType != 'virtual') {
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
                    } else if (response.index == '1' && response.creationType != 'virtual') {
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
                    } else if (response.index == '2' && response.creationType != 'virtual') {
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
                    } else if (response.index == '3' && response.creationType != 'virtual') {
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
                    } else if (response.index == '4' && response.creationType != 'virtual') {
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
                    } else if (response.index == '5' && response.creationType != 'virtual') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').fadeIn('slow');
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '6' && response.creationType != 'virtual') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').fadeIn('slow');
                        $('#ppp').focus();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '7' && response.creationType != 'virtual') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').fadeIn('slow');
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '8' && response.creationType != 'virtual') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').fadeIn('slow');
                        $('#last_cost').focus();
                        $('#divPart9').hide();
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '9' && response.creationType != 'virtual') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').fadeIn('slow');
                        $('#divPart10').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Create Part');
                    } else if (response.index == '10' && response.creationType != 'virtual') {
                        $('#divPart0').hide();
                        $('#divPart1').hide();
                        $('#divPart2').hide();
                        $('#divPart3').hide();
                        $('#divPart4').hide();
                        $('#divPart5').hide();
                        $('#divPart6').hide();
                        $('#divPart7').hide();
                        $('#divPart8').hide();
                        $('#divPart9').hide();
                        $('#divPart10').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    }

                    // Virtual Cards
                    if (response.index == '1' && response.creationType != 'create') {
                        $('#divPart0').hide();
                        $('#divVirtualPart1').fadeIn('slow');
                        $('#divVirtualPart2').hide();
                        $('#divVirtualPart3').hide();
                        $('#divVirtualPart2A').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '2' && response.creationType != 'create') {
                        $('#divPart0').hide();
                        $('#divVirtualPart1').hide();
                        $('#divVirtualPart2A').hide();

                        if (response.part.vendor_id == '80') {

                            $('#divVirtualPart2').fadeIn('slow');
                        } else {

                            $('#divVirtualPart2A').fadeIn('slow');
                        }

                        $('#divVirtualPart3').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Next Step');
                    } else if (response.index == '3' && response.creationType != 'create') {
                        $('#divPart0').hide();
                        $('#divVirtualPart1').hide();
                        $('#divVirtualPart2').hide();
                        $('#divVirtualPart3').fadeIn('slow');
                        $('#divVirtualPart2A').hide();

                        $('.mainGroup').fadeIn('slow');

                        $('#partCancel').text('Close');
                        $('#saveForm').text('Create Part');

                        virtualLoadData();
                    } else if (response.index == '4' && response.creationType != 'create') {
                        $('#divPart0').hide();
                        $('#divVirtualPart1').hide();
                        $('#divVirtualPart2').hide();
                        $('#divVirtualPart3').hide();
                        $('#divPart10').fadeIn('slow');
                        $('.mainGroup').fadeOut('slow');
                        $('#backForm').hide('slow');
                        $('#saveForm').hide('slow');
                        $('#divVirtualPart2A').hide();

                        $('#clickHereBtnAppend').html('The part <span id="lastLink"></span> is finished and available to be managed by the system.<br>If you need to review this information please <a href="/edit/'+response.part.id+'/part" class="fw-bolder me-1">click here</a> to verify all part info.');
                        $('#lastLink').append('<a href="/edit/'+response.part.id+'/part" class="fw-bolder me-1">'+response.part.part_no+' - '+response.part.desc+'</a>');

                    }

                    if(response.index == 10 || response.index == 0) {
                        $('.mainGroup').fadeOut('slow');
                    } else if (response.index == 4 && response.creationType != 'create') {

                        $('.mainGroup').fadeOut('slow');
                    } else {
                        $('.mainGroup').fadeIn('slow');
                    }

                    if (response.index > 1 && response.index != 10 && response.creationType == 'create') {
                        $('#backForm').show('slow');
                    } else if (response.index > 1 && response.index != '4' && response.creationType == 'virtual') {

                        $('#backForm').show('slow');
                    } else {

                        $('#backForm').hide('slow');
                    }

                    let confirm = $('#form_completion').val();

                    if (confirm == 1 && response.index != 9 && response.index != 10) {
                        $('#goToReview').show('slow');
                    } else {
                        $('#goToReview').hide('slow');
                    }

                    if (response.index > 6) {
                        let metal_stamp = $('#metal_stamp').val();
                        if (metal_stamp == '129') {
                            $('.s925').show('slow');
                            $('.otherStamp').hide('slow');
                        } else {
                            $('.s925').hide('slow');
                            $('.otherStamp').show('slow');
                        }
                    }

                    if (response.index == '9') {

                        loadPartData();
                    }

                    if(response.index > '2') {

                        if (response.schema.has_ring == 1) {
                            $('.hasRing').show('slow');
                        }

                        if (response.schema.has_bangle == 1) {
                            $('.hasBangle').show('slow');
                        }

                        if (
                            response.schema.has_guage == 1 &&
                            response.part.category_id != '75' &&
                            response.part.category_id != '32' &&
                            response.part.category_id != '22'
                        ) {
                            $('.hasGuage').show('slow');
                        }

                        if (response.schema.has_thickness == 1) {
                            $('.hasThickness').show('slow');
                        }
                    }
                }
            }
        })
    }

    // Get all DropDown Data
    function getDropdownData() {

        let part_id = $('#part_id').val();

        $.ajax({
            type: "get",
            url: "{{ route('part.getDropdown') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part: part_id
            },
            success:function(response) {
                if (response.success) {

                    let lang = $('#lang').val();

                    // Vendor Options Append
                    for (let v = 0; v < response.vendor.length; v++) {
                        let selected = (response.vendor[v].id == response.part.vendor_id) ? 'selected' : '';
                        $('#vendor').append('<option value="'+response.vendor[v].id+'" '+selected+'>'+response.vendor[v].account_no+' - '+response.vendor[v].name+'</option>');
                    }

                    // Category Option Append
                    for (let c = 0; c < response.product_category.length; c++) {
                        for(let ps = 0; ps < response.product_category[c].sub_options.length; ps++) {
                            let selected = (response.product_category[c].sub_options[ps].id == response.part.category_id) ? 'selected' : '';
                            if(response.product_category[c].status=="active" && response.product_category[c].sub_options[ps].status=="active") {
                                $('#category_id').append('<option value="' + response.product_category[c].sub_options[ps].id + '" ' + selected + ' data-cat_parent="' + response.product_category[c].sub_options[ps].p_id + '" data-sub-cat="' + response.product_category[c].sub_options[ps].name_in_english + '" data-cat_name="' + response.product_category[c].name_in_english + '">' + response.product_category[c]['name_in_' + lang] + ' >> ' + response.product_category[c].sub_options[ps]['name_in_' + lang] + '</option>');
                            }
                        }
                    }

                    // Part Type Option Append
                    for (let p = 0; p < response.product_type.length; p++) {
                        let selected = (response.product_type[p].id == response.part.type_id) ? 'selected' : '';
                        $('#type_id').append('<option value="'+response.product_type[p].id+'" '+selected+'>'+response.product_type[p]['name_in_'+lang]+'</option>');
                    }

                    // UOM Option Append
                    for (const [key, value] of Object.entries(response.uoms['product'])) {
                        let selected = (key == response.part.uom) ? 'selected' : '';
                        $('#uom').append('<option value="'+key+'" '+selected+'>'+value+'</option>');
                    }

                    // Base Material Append
                    for (let b = 0; b < response.base_material.length; b++) {
                        let selected = (response.base_material[b].id == response.part.base_material_id) ? 'selected' : '';
                        $('#base_material').append('<option value="'+response.base_material[b].id+'" '+selected+'>'+response.base_material[b]['name_in_'+lang]+'</option>');
                    }

                    let base_material = $('#base_material :selected').val();

                    getMetalStamp(base_material, response.part.metal_stamp_id);

                    // Metal Stamp Append
                    // for (let m = 0; m < response.metal_stamp.length; m++) {
                    //     let selected = (response.metal_stamp[m].id == response.part.metal_stamp_id) ? 'selected' : '';
                    //     $('#metal_stamp').append('<option value="'+response.metal_stamp[m].id+'" '+selected+'>'+response.metal_stamp[m]['name_in_'+lang]+'</option>');
                    // }

                    // Finish Type Append
                    for (let f = 0; f < response.finish_type.length; f++) {
                        let selected = (response.finish_type[f].id == response.part.finish_type_id) ? 'selected' : '';
                        $('#finish_type').append('<option value="'+response.finish_type[f].id+'" '+selected+'>'+response.finish_type[f]['name_in_'+lang]+'</option>');
                    }

                    // Detail Type Append
                    for (let d = 0; d < response.detail_type.length; d++) {
                        let selected = (response.detail_type[d].id == response.part.detail_type_id) ? 'selected' : '';
                        $('#detail_type').append('<option value="'+response.detail_type[d].id+'" '+selected+'>'+response.detail_type[d]['name_in_'+lang]+'</option>');
                    }

                    // Detail Color Append
                    for (let dc = 0; dc < response.detail_color.length; dc++) {
                        let selected = (response.detail_color[dc].id == response.part.detail_color_id) ? 'selected' : '';
                        $('#detail_color').append('<option value="'+response.detail_color[dc].id+'" '+selected+'>'+response.detail_color[dc]['name_in_'+lang]+'</option>');
                    }

                    // Shape Append
                    for (let s = 0; s < response.shape.length; s++) {
                        let selected = (response.shape[s].id == response.part.shape_id) ? 'selected' : '';
                        $('#shape').append('<option value="'+response.shape[s].id+'" '+selected+'>'+response.shape[s]['name_in_'+lang]+'</option>');
                    }

                    // Gender Append
                    for (let g = 0; g < response.product_gender.length; g++) {
                        $('#gender').append('<option value="'+response.product_gender[g].id+'">'+response.product_gender[g]['name_in_'+lang]+'</option>');
                    }

                    // Part Continue Gender append
                    if (response.part.genders) {

                        for(let g = 0; g < response.part.genders.length; g++) {

                            let table = document.getElementById("genderRow");
                            let tbodyRowCount = table.rows.length + 1;

                            let lang = $('#lang').val();

                            let defaultRow = (response.part.genders[g].pivot.default == 1) ? '<span class="badge badge-primary">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="genderDefaultCheck" name="genderDefaultCheck[]">' : '';

                            let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefault" onclick="genderChangeDefault('+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class=" remGender" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button>' : '' ;


                            $('#genderRow').append(
                                `
                                    <tr>
                                        <td style="text-align: center">`+ tbodyRowCount +`</td>
                                        <td>
                                            `+ response.part.genders[g]['name_in_'+lang] +` &nbsp;&nbsp; `+defaultRow+`
                                            <input type="hidden" value="`+response.part.genders[g].id+`" data-name="`+ response.part.genders[g]['name_in_'+lang] +`" name="genderArray[]" class="genderArray">
                                        </td>
                                        <td style="text-align: left">`+changeDefault+`</td>
                                    </tr>
                                `
                            );
                        }
                    }

                    // Style Append
                    for (let s = 0; s < response.style.length; s++) {
                        $('#style').append('<option value="'+response.style[s].id+'">'+response.style[s]['name_in_'+lang]+'</option>')
                    }

                    // Part Continue Style Append
                    if (response.part.styles) {

                        for (let s = 0; s < response.part.styles.length; s++) {
                            let table = document.getElementById("styleRow");
                            let tbodyRowCount = table.rows.length + 1;

                            let lang = $('#lang').val();

                            let defaultRow = (response.part.styles[s].pivot.default == 1) ? '<span class="badge badge-primary">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="defaultCheck" name="defaultCheck[]">' : '';

                            let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefault" onclick="changeDefault('+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class=" remStyle" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button>' : '' ;

                            $('#styleRow').append(
                                `
                            <tr>
                                <td style="text-align: center">`+ tbodyRowCount +`</td>
                                <td>
                                    `+ response.part.styles[s]['name_in_'+lang] +` &nbsp; `+ defaultRow +`
                                    <input type="hidden" value="`+response.part.styles[s].id+`" data-name="`+response.part.styles[s]['name_in_'+lang]+`" name="styleArray[]" class="styleArray">
                                    <input type="hidden" value="`+response.part.styles[s]['name_in_'+lang]+`" name="styleNameArray[]" class="styleNameArray">
                                </td>
                                <td style="text-align: left">`+ changeDefault +` </td>
                            </tr>
                        `
                            );
                        }
                    }

                    // Uom Length Append
                    for (const [key, value] of Object.entries(response.uoms['length'])) {
                        let selected = (key == response.part.uom_length) ? 'selected' : '';
                        $('#uom_length').append('<option value="'+key+'" '+selected+'>'+value+'</option>');
                    }

                    // Uom Weight Append
                    for (const [key, value] of Object.entries(response.uoms['weight'])) {
                        let selected = (key == response.part.uom_weight) ? 'selected' : '';
                        $('#uom_weight').append('<option value="'+key+'" '+selected+'>'+value+'</option>');
                    }

                    // Stone Type Append
                    for (let st = 0; st < response.stone_type.length; st++) {
                        $('#stone_type').append('<option value="'+ response.stone_type[st].id +'">'+ response.stone_type[st]['name_in_'+lang] +'</option>');
                    }

                    if (response.part.stones) {

                        for (let sd = 0; sd < response.part.stones.length; sd++) {

                            let table = document.getElementById("stoneRow");
                            let tbodyRowCount = table.rows.length + 1;

                            let lang = $('#lang').val();

                            let defaultRow = (response.part.stones[sd].default == 1) ? '<span class="badge badge-primary">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="defaultCheck" name="stoneDefaultCheck[]">' : '';

                            let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefault" onclick="stoneChangeDefault('+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class="remStone" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button>' : '' ;

                            $('#stoneRow').append(
                                `
                                    <tr>
                                        <td style="text-align: center">`+ tbodyRowCount +`</td>
                                        <td>
                                            `+ response.part.stones[sd].type['name_in_'+lang] +`
                                            <input type="hidden" value="`+response.part.stones[sd].type.id+`" data-name="`+response.part.stones[sd].type['name_in_'+lang]+`" data-color_id="`+response.part.stones[sd].color.id+`" data-color_name="`+response.part.stones[sd].color['name_in_'+lang]+`" name="stoneArray[]" class="stoneArray">
                                            <input type="hidden" value="`+response.part.stones[sd].type['name_in_'+lang]+`" name="stoneNameArray[]" class="stoneNameArray">
                                        </td>
                                        <td>
                                            `+ response.part.stones[sd].color['name_in_'+lang] +` &nbsp; `+ defaultRow +`
                                            <input type="hidden" value="`+response.part.stones[sd].color.id+`" data-name="`+response.part.stones[sd].color['name_in_'+lang]+`" name="colorArray[]" class="colorArray">
                                            <input type="hidden" value="`+response.part.stones[sd].color['name_in_'+lang]+`" name="colorNameArray[]" class="colorNameArray">
                                        </td>
                                        <td style="text-align: left">`+ changeDefault +` </td>
                                    </tr>
                                `
                            );
                        }
                    }

                    @if(Route::is('part.duplicate'))

                        if (!response.part.style) {
                            $('#noStyle').prop('checked', true);
                            $('#addStyle').prop('disabled', true);
                            $('#style').prop('disabled', true);
                            $('.noStyle').hide();
                        }

                        if (response.part.stones.length == '0') {
                            $('#noStone').prop('checked', true);
                            $('#stone_type').prop('disabled', true);
                            $('#stone_color').prop('disabled', true);
                            $('#addStone').prop('disabled', true);
                            $('.noStone').hide();
                        }

                    @endif

                    // Stone Color Append
                    for (let sc = 0; sc < response.stone_color.length; sc++) {
                        $('#stone_color').append('<option value="'+ response.stone_color[sc].id +'">'+ response.stone_color[sc]['name_in_'+lang] +'</option>');
                    }

                    // Ring Size Append
                    for (let r = 0; r < response.ring_size.length; r++) {
                        let selected = (response.ring_size[r].id == response.part.ring_size_id) ? 'selected' : '';
                        $('#ring_size').append('<option value="'+response.ring_size[r].id+'" '+selected+'>'+response.ring_size[r]['name_in_'+lang]+'</option>');
                    }

                    // Bangle Size Append
                    for (let b = 0; b < response.bangle_size.length; b++) {
                        let selected = (response.bangle_size[b].id == response.part.bangle_size_id) ? 'selected' : '';
                        $('#bangle_size').append('<option value="'+response.bangle_size[b].id+'" '+selected+'>'+response.bangle_size[b]['name_in_'+lang]+'</option>');
                    }

                    // Guage Append
                    for (let g = 0; g < response.guage.length; g++) {
                        let selected = (response.guage[g].id == response.part.guage_id) ? 'selected' : '';
                        $('#guage').append('<option value="'+response.guage[g].id+'" '+selected+'>'+response.guage[g]['name_in_'+lang]+'</option>');
                    }

                    // Quality Append
                    for (let q = 0; q < response.quality.length; q++) {
                        let selected = (response.quality[q].id == response.part.quality_id) ? 'selected' : '';
                        $('#quality').append('<option value="'+response.quality[q].id+'" '+selected+'>'+response.quality[q]['name_in_'+lang]+'</option>');
                    }

                    // Location Append
                    // for (let l = 0; l < response.location.length; l++) {
                    //     let selected = (response.location[l].id == response.part.location) ? 'selected' : '';
                    //     $('#location').append('<option value="'+response.location[l].id+'" '+selected+'>'+response.location[l].name+'</option>');
                    // }

                    // Currency Append
                    for (let c = 0; c < response.currency.length; c++) {
                        let selected = (response.currency[c].id == response.part.currency_id) ? 'selected' : '';
                        $('#currency').append('<option value="'+response.currency[c].id+'" '+selected+'>'+response.currency[c].symbol+' - '+response.currency[c].name+'</option>');
                    }


                    $('#form_completion').val(response.part.form_completed);

                }
            }
        })
    }

    $('#saveForm').on('click', function () {
        savePartForm();
    });

    // Save Part 1 Form
    function savePartForm() {
        //  let location_input_text = $("#part_location_input").val();
        //  checkLocationAccuracy(location_input_text);
        let index = $('#Index').val();
        let creationType = $('#CreationType').val();

        $('#category_id').attr('disabled', false);
        $('#type_id').attr('disabled', false);
        $('#uom').attr('disabled', false);

        var required_inputs = $('input,textarea,select').filter('[required]:visible');
        var count = 0;

        for(var i = 0; i < required_inputs.length; i++){
            var ids = required_inputs[i].id;
            $('#error-'+ids).fadeOut('slow');
            $('#'+ids).css('border', '1px solid lightgrey');
            var vals = required_inputs[i].value;
            if(vals == ''){
                $('#error-'+ids).fadeIn('slow');
                count++;
                $('#'+ids).css('border', '1px solid red');
            }
        }

        if(count > 0){
            setTimeout(function () {
                toastr['error'](
                    'Error! Some Required Fields are not valid.',
                    'Error!',
                    {
                        closeButton: true,
                        tapToDismiss: true
                    }
                );
            }, 2000);
            return false;
        }

        if (index == '7') {

            let location = $('#part_location_id').val();

            if (location == '') {
                if($('#noInventory').prop('checked')) {

                } else {

                    $('#part_location_input').css('border', '1px solid red');
                    $('#error-part_location_input').fadeIn('slow');
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Location Not Found.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                    return false;
                }
            }

            let unit_cost = $('#unit_cost').val();
            var exchangeRate = $('#exchange_rate').val();
            var laborCost = $('#labor_cost').val();
            var silverCost = $('#silver_cost').val();
            var duty = $('#duty').val();

            if (unit_cost % 1 <= 0 && silverCost == null) {
                setTimeout(function () {
                    toastr['error'](
                        'Error! Last Cost not equal to 0.',
                        'Error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
                return false;
            }

            // Check Silver Cost
            if (silverCost != '') {
                if (Number(laborCost) == '0' || Number(silverCost) == '0' || Number(exchangeRate) == '0') {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Last Cost not equal to 0.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                    return false;
                }
            }
        }

        if (creationType == 'virtual') {

            let vendor = $('#vendor_id').val();
            for (instance in CKEDITOR.instances)
            {
                CKEDITOR.instances[instance].updateElement();
            }

            var rowCount = $("#virtualConfirmPoolBody tr").length;

            let description = $('#virtualDescription').val();

            if (vendor == '80' || vendor == '81') {
                if (description == '') {
                    $('#error-virtualDescription').fadeIn('slow');
                    return false;
                } else {
                    $('#error-virtualDescription').fadeOut('slow');
                }
            }

            if(rowCount < 2 && index == '2' && vendor == '81') {

                $('#error-vPool').show();
                return false;
            } else {

                $('#error-vPool').hide();
            }

            var rowCount2 = $('#virtualConfirmPartBody tr').length;

            if(rowCount2 < 2 && index == '2' && vendor == '80') {

                $('#error-partBody').show();
                return false;
            } else {

                $('#error-partBody').hide();
            }
        }

        let part_id = $('#part_id').val();
        let formData = new FormData($('#Step0Form')[0]);
        formData.append('index', index);
        formData.append('part_id', part_id);
        formData.append('creationType', creationType);

        $.ajax({
            url:"{{ route('part_store.steps') }}",
            data: formData,
            type:"post",
            processData:false,
            cache:false,
            contentType:false,
            success:function(response) {
                if(response.locationSuccess == false){
                        $("#part_location_input").css("border",'1px solid red');
                        $("#error-part_location_input").css("display","block");
                        $("#error-part_location_input").empty();
                        $("#error-part_location_input").text(response.locationErrorMsg);
                    }else{
                        $("#part_location_input").css("border",'');
                        $("#error-part_location_input").css("display","none");
                        $("#error-part_location_input").empty();
                        $("#error-part_location_input").text('Location is Required.');
                    }
                if (response.success == true) {
                    // console.log('inside',response);

                    // setTimeout(function () {
                    //     toastr['success'](
                    //         'Success! '+ response.message,
                    //         'Success!',
                    //         {
                    //             closeButton: true,
                    //             tapToDismiss: true
                    //         }
                    //     );
                    // }, 2000);

                    // Update Index
                    $('#Index').val(response.index);
                    // Parse Part No
                    $('#partNo').val(response.part.part_no);
                    $('#part_no_10').text(response.part.part_no);
                    // Parse Part Description
                    $('#partDescription').val(response.part.desc);
                    $('#desc_10').text(response.part.desc);
                    // Parse Part Sku
                    $('#partSku').val(response.part.sku);
                    // Parse Part Upc
                    $('#partUpc').val(response.part.upc);
                    // Parse Part Id to hidden Vaiable
                    $('#part_id').val(response.part.id);
                    // Change Form tp Load Base
                    base();
                    // Parse Inventory UOM
                    $('#inventoryUOM').val(response.part.uom);
                    // Parse Vendor Detail
                    if (response.index == '8') {
                        $('#vendorDetail').val(response.part.vendor.account_no+' - '+response.part.vendor.name);
                        $('#vendor_uom').val(response.part.uom);
                        $('#vendor_part_no').val(response.part.part_no);
                    }

                    // Form Complete Update in input
                    $('#form_completion').val(response.part.form_completed);

                    if (response.index == '9') {

                        loadPartData();
                    }
                    // Save Form Button Handle
                    if (response.index == '10') {
                        $('#saveForm').hide('slow');
                        $('#duplicateBtnAppend').empty();
                        $('#duplicateBtnAppend').append('<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#duplicateTypeStep10" class="btn btn-outline btn-outline-primary btn-active-primary m-2"  type="button">Duplicate </a>');
                        let url="{{route('part.duplicate',':id')}}";
                        url=url.replace(':id',response.part.id);
                        $('.duplicateTypeRow').html('<a href='+url+' type="button"  class="btn btn-primary col-6">Sequence</a> <a href="javascript:void(0)" id="variation_step10"  data-bs-toggle="modal" data-bs-target="#create_variation_on_step10_modal" data-id="'+response.part.id+'" type="button" class="btn btn-light col-6 variation-dropdown" >Variation</a>');
                        $('#variation-dropdown_step10').select2({
                            dropdownParent: $('#create_variation_on_step10_modal')
                        });
                        $('#variation_step10').on('click', function () {
                            getVariationDropdown(response.part.id);
                            $('#variation_step10_modal_value').val($('#variation_step10').attr('data-id'));

                        });
                        $('#create_variation_step10').on('click', function () {
                            var variation = $('#variation-dropdown_step10').val();
                            window.location = "/part/" + part_id + "/variation/" + variation;


                        });
                        $('#clickHereBtnAppend').html('The part <span id="lastLink"></span> is finished and available to be managed by the system.<br>If you need to review this information please <a href="/edit/'+response.part.id+'/part" class="fw-bolder me-1">click here</a> to verify all part info.');
                        $('#lastLink').append('<a href="/edit/'+response.part.id+'/part" class="fw-bolder me-1">'+response.part.part_no+' - '+response.part.desc+'</a>');
                    } else {
                        $('#duplicateBtnAppend').empty();
                        $('#lastLink').empty();
                        $('#saveForm').show('slow');
                    }

                    // Set UOM
                    if (response.index == '2') {
                        if (
                            response.part.category.p_id == '1'  ||
                            response.part.category.p_id == '3'  ||
                            response.part.category.p_id == '11' ||
                            response.part.category.p_id == '10' ||
                            response.part.category.p_id == '9'  ||
                            response.part.category.p_id == '15' ||
                            response.part.category.p_id == '12' ||
                            response.part.category.p_id == '18'
                        ) {
                            $('#uom_length').val('in').trigger('change');
                        } else if (
                            response.part.category.p_id == '14' ||
                            response.part.category.p_id == '6'  ||
                            response.part.category.p_id == '8'  ||
                            response.part.category.p_id == '13' ||
                            response.part.category.p_id == '2'  ||
                            response.part.category.p_id == '5'  ||
                            response.part.category.p_id == '16' ||
                            response.part.category.p_id == '7'  ||
                            response.part.category.p_id == '4'  ||
                            response.part.category.p_id == '19'
                        ) {
                            $('#uom_length').val('mm').trigger('change');
                        }

                        $('#uom_weight').val('g').trigger('change');
                    }

                    if(response.index == '5') {

                        if (response.schema.has_ring == 1) {
                            $('.hasRing').show('slow');
                        }

                        if (response.schema.has_bangle == 1) {
                            $('.hasBangle').show('slow');
                        }

                        if (
                            response.schema.has_guage == 1 &&
                            response.part.category_id != '75' &&
                            response.part.category_id != '32' &&
                            response.part.category_id != '22'
                        ) {
                            $('.hasGuage').show('slow');
                        }

                        if (response.schema.has_thickness == 1) {
                            $('.hasThickness').show('slow');
                        }
                    }

                } else if (response.genderError == true) {
                    setTimeout(function () {
                        toastr['error'](
                            'Oh snap! Gender Required',
                            'error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if (response.stylError == true) {
                    setTimeout(function () {
                        toastr['error'](
                            'Oh snap! Style Required',
                            'error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if (response.stoneError == true) {
                    setTimeout(function () {
                        toastr['error'](
                            'Oh snap! Stone Required',
                            'error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else {

                    setTimeout(function () {
                        toastr['error'](
                            response.message,
                            'error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000)
                }
            },
            error:function(e) {

                setTimeout(function () {
                    toastr['error'](
                        'Oh snap! Some required fields are not valid.',
                        'error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
            }
        });
    }
    function getVariationDropdown(part) {



        $.ajax({
            type: "get",
            url: "{{ route('variation.getDropdown') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'part_id':part,

            },
            success:function(response) {
                if (response.success) {
                    $('#variation-dropdown_step10').find('option').remove();
                    let categoryNameArray1=['Anklets','Bracelets','Brooches','Earring and Pendant Sets','Earrings','Findings','Hoops','Necklace Sets','Necklaces','Pendants','Rosaries'];
                    let  varaitionNameArray1=["Detail Color","Detail Type",'Finish Type and Stone Color'];
                    let categoryNameArray2=categoryNameArray1.concat(["Bangles","Rings"]);
                    let  varaitionNameArray2=["Finish Type",'Stone Color','Style'];
                    let categoryNameArray3=['Anklets','Bracelets','Earring and Pendant Sets','Hoops','Necklace Sets','Necklaces','Rosaries'];
                    let  varaitionNameArray3=['Length','Finish Type and Length'];
                    let categoryNameArray4=["Bangles","Rings"];
                    let  varaitionNameArray4=['Size','Finish Type and Size','Size and Stone Color'];

                    // Variation Append
                    for (let b = 0; b < response.variationType.length; b++) {
                        if(varaitionNameArray1.includes(response.variationType[b]['name_in_english']) && categoryNameArray1.includes(response.categoryName)){
                            $('#variation-dropdown_step10').append('<option value="' + response.variationType[b].id + '">' + response.variationType[b]['name_in_english'] + '</option>');
                        }
                        if(varaitionNameArray2.includes(response.variationType[b]['name_in_english']) && categoryNameArray2.includes(response.categoryName)){
                            $('#variation-dropdown_step10').append('<option value="' + response.variationType[b].id + '">' + response.variationType[b]['name_in_english'] + '</option>');
                        }
                        if(varaitionNameArray3.includes(response.variationType[b]['name_in_english']) && categoryNameArray3.includes(response.categoryName)){
                            $('#variation-dropdown_step10').append('<option value="' + response.variationType[b].id + '">' + response.variationType[b]['name_in_english'] + '</option>');
                        }
                        if(varaitionNameArray4.includes(response.variationType[b]['name_in_english']) && categoryNameArray4.includes(response.categoryName)){
                            $('#variation-dropdown_step10').append('<option value="' + response.variationType[b].id + '">' + response.variationType[b]['name_in_english'] + '</option>');
                        }
                    }


                }
            }
        })
    }

    // Handle detail Color Against detail Type
    $('#detail_type').on('change', function () {
        var optionSelected = $(this).find("option:selected");
        var type = optionSelected.val();

        if (type == '143' ||
            type == '144' ||
            type == '146' ||
            type == '148' ||
            type == '149') {
                $('.detail_color_div').fadeIn('slow');
        } else {
            $('.detail_color_div').fadeOut('slow');
        }
    })


    // Add gender in List Function
    $('#addGender').on('click', function () {

        let gender = $('#gender').val();
        let part_id=$('#part_id').val();

        if ($('.genderArray').val()) {
            var count = 0;
            $('.genderArray').map(function () {
                if ($(this).val() == gender) {
                    count++;
                }
            });

            if (count > 0) {
                return false;
            }
        }

        $.ajax({
            type: "get",
            url: "{{ route('part.getGender') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'gender': gender,
                'id': $('#part_id').val(),

            },
            success:function(response) {
                generateGendersDropDown(response);
                if (response.success) {
                    let table = document.getElementById("genderRow");
                    let tbodyRowCount = table.rows.length + 1;

                    let lang = $('#lang').val();

                    let defaultRow = (tbodyRowCount == 1) ? '<span class="badge badge-primary">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="genderDefaultCheck" name="genderDefaultCheck[]">' : '';

                    let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefault" onclick="setDefaultGender('+gender+','+part_id+','+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> Default</button><button onclick="deleteGender('+gender+','+part_id+')" type="button" class=" remGender" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button>' : '' ;

                    // $('#gender').val('').trigger('change');

                    $('#genderRow').append(
                        `
                            <tr>
                                <td style="text-align: center">`+ tbodyRowCount +`</td>
                                <td>
                                    `+ response.gender['name_in_'+lang] +` &nbsp;&nbsp; `+defaultRow+`
                                    <input type="hidden" value="`+response.gender.id+`" data-name="`+response.gender['name_in_'+lang]+`" name="genderArray[]" class="genderArray">
                                </td>
                                <td style="text-align: left">`+ changeDefault +` </td>
                            </tr>
                        `
                    );
                }
            }
        })
    });

    // Remove Gender Rows
    $("#genderRow").on('click', '.remGender', function () {
        $(this).parent().parent().remove();
    });

    function genderChangeDefault(index) {

        let gender = [];
        let defaultGender = [];
        let part_id=$('#part_id').val();
        $('.genderArray').map(function (looop) {
            looop = looop + 1;

            if(looop == index) {

                defaultGender.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                });
            } else {

                gender.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                });
            }
        });

        $('#genderRow').empty();

        let serial = 1;

        $('#genderRow').append(
            `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ defaultGender[0].name +` &nbsp;&nbsp; <span class="badge badge-primary">Default</span><input type="hidden" value="`+ serial +`" id="genderDefaultCheck" name="genderDefaultCheck[]">
                        <input type="hidden" value="`+defaultGender[0].id+`" data-name="`+defaultGender[0].name+`" name="genderArray[]" class="genderArray">
                    </td>
                    <td style="text-align: left"></td>
                </tr>
            `
        );

        serial++;

        for (let s = 0; s < gender.length; s++) {
            $('#genderRow').append(
                `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ gender[s].name +` &nbsp;&nbsp;
                        <input type="hidden" value="`+gender[s].id+`" data-name="`+gender[s].name+`" name="genderArray[]" class="genderArray">
                    </td>
                    <td style="text-align: left"><button type="button" style="background: transparent; border: none" class="changeDefault" onclick="setDefaultGender(`+gender[s].id+`,`+part_id+`,`+ serial +`)"><i class="fa fa-arrow-circle-up"></i> Default</button><button onclick="deleteGender(`+gender[s].id+`,`+part_id+`)" type="button" class=" remGender" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button> </td>
                </tr>
            `
            );
            serial++;
        }
    }

    // Add Style in List Function
    $('#addStyle').on('click', function () {

        let style = $('#style').val();

        if ($('.styleArray').val()) {
            var count = 0;
            $('.styleArray').map(function () {
                if ($(this).val() == style) {
                    count++;
                }
            });

            if (count > 0) {
                return false;
            }
        }

        $.ajax({
            type: "get",
            url: "{{ route('part.getStyle') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'style': style
            },
            success:function(response) {
                if (response.success) {
                    let table = document.getElementById("styleRow");
                    let tbodyRowCount = table.rows.length + 1;

                    $('#style').val('').trigger('change');

                    let lang = $('#lang').val();

                    let defaultRow = (tbodyRowCount == 1) ? '<span class="badge badge-primary">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="defaultCheck" name="defaultCheck[]">' : '';

                    let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefault" onclick="changeDefault('+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class=" remStyle" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button>' : '' ;

                    $('#styleRow').append(
                        `
                            <tr>
                                <td style="text-align: center">`+ tbodyRowCount +`</td>
                                <td>
                                    `+ response.style['name_in_'+lang] +` &nbsp; `+ defaultRow +`
                                    <input type="hidden" value="`+response.style.id+`" data-name="`+response.style['name_in_'+lang]+`" name="styleArray[]" class="styleArray">
                                    <input type="hidden" value="`+response.style['name_in_'+lang]+`" name="styleNameArray[]" class="styleNameArray">
                                </td>
                                <td style="text-align: left">`+ changeDefault +` </td>
                            </tr>
                        `
                    );
                }
            }
        })
    });

    // Remove Gender Rows
    $("#styleRow").on('click', '.remStyle', function () {
        $(this).parent().parent().remove();
    });

    // Change Default
    function changeDefault (index) {
        let style = [];
        let defaultStyle = [];
        $('.styleArray').map(function (looop) {
            looop = looop + 1;

            if(looop == index) {

                defaultStyle.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                });
            } else {

                style.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                });
            }
        });

        $('#styleRow').empty();

        let serial = 1;

        $('#styleRow').append(
            `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ defaultStyle[0].name +` <span class="badge badge-primary">Default</span><input type="hidden" value="`+ serial +`" id="defaultCheck" name="defaultCheck[]">
                        <input type="hidden" value="`+defaultStyle[0].id+`" data-name="`+defaultStyle[0].name+`" name="styleArray[]" class="styleArray">
                        <input type="hidden" value="`+defaultStyle[0].name+`" name="styleNameArray[]" class="styleNameArray">
                    </td>
                    <td style="text-align: left"> </td>
                </tr>
            `
        );

        serial++;

        for (let s = 0; s < style.length; s++) {
            $('#styleRow').append(
                `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ style[s].name +`
                        <input type="hidden" value="`+style[s].id+`" data-name="`+style[s].name+`" name="styleArray[]" class="styleArray">
                        <input type="hidden" value="`+style[s].name+`" name="styleNameArray[]" class="styleNameArray">
                    </td>
                    <td style="text-align: left"><button type="button" style="background: transparent; border: none" class="changeDefault" onclick="changeDefault(`+ serial +`)"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class=" remStyle" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button> </td>
                </tr>
            `
            );
            serial++;
        }
    }

    // Handle This Part Does not have Style
    $('#noStyle').on('click', function () {

        if($(this).prop('checked') == true) {
            $('#style').val('').trigger('change');
            $('#addStyle').prop('disabled', true);
            $('#style').prop('disabled', true);
            $('#styleRow').hide();
            $('.noStyle').hide();
        } else {
            $('#addStyle').prop('disabled', false);
            $('#style').prop('disabled', false);
            $('#styleRow').show();
            $('.noStyle').show();
        }
    });

    // Add Stone in and Stone Color in List
    $('#addStone').on('click', function () {

        let stone = $('#stone_type').val();
        let color = $('#stone_color').val();

        var count = 0;
        var count2 = 0;

        if ($('.stoneArray').val()) {
            $('.stoneArray').map(function () {
                if ($(this).val() == stone) {
                    count++;
                }
            });
        }

        if ($('.colorArray').val()) {
            $('.colorArray').map(function () {
                if ($(this).val() == color) {
                    count2++;
                }
            });
        }

        if (count > 0 && count2 > 0) {
            return false;
        }

        $.ajax({
            type: "get",
            url: "{{ route('part.getStone') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'stone': stone,
                'color': color
            },
            success:function(response) {
                if (response.success) {
                    let table = document.getElementById("stoneRow");
                    let tbodyRowCount = table.rows.length + 1;

                    $('#stone_type').val('').trigger('change')
                    $('#stone_color').val('').trigger('change');

                    let lang = $('#lang').val();

                    let defaultRow = (tbodyRowCount == 1) ? '<span class="badge badge-primary">Default</span><input type="hidden" value="'+ tbodyRowCount +'" id="defaultCheck" name="stoneDefaultCheck[]">' : '';

                    let changeDefault = (defaultRow == '') ? '<button type="button" style="background: transparent; border: none" class="changeDefault" onclick="stoneChangeDefault('+ tbodyRowCount +')"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class="remStone" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button> ' : '' ;

                    $('#stoneRow').append(
                        `
                            <tr>
                                <td style="text-align: center">`+ tbodyRowCount +`</td>
                                <td>
                                    `+ response.stone['name_in_'+lang] +`
                                    <input type="hidden" value="`+response.stone.id+`" data-name="`+response.stone['name_in_'+lang]+`" data-color_id="`+response.color.id+`" data-color_name="`+response.color['name_in_'+lang]+`" name="stoneArray[]" class="stoneArray">
                                    <input type="hidden" value="`+response.stone['name_in_'+lang]+`" name="stoneNameArray[]" class="stoneNameArray">
                                </td>
                                <td>
                                    `+ response.color['name_in_'+lang] +` &nbsp; `+ defaultRow +`
                                    <input type="hidden" value="`+response.color.id+`" data-name="`+response.color['name_in_'+lang]+`" name="colorArray[]" class="colorArray">
                                    <input type="hidden" value="`+response.color['name_in_'+lang]+`" name="colorNameArray[]" class="colorNameArray">
                                </td>
                                <td style="text-align: left">`+ changeDefault +`</td>
                            </tr>
                        `
                    );
                }
            }
        })
    });

    // Remove Stone Row in Table
    $("#stoneRow").on('click', '.remStone', function () {
        $(this).parent().parent().remove();
    });

    // Change Default Stone Function
    function stoneChangeDefault (index) {

        let stone = [];
        let defaultStone = [];

        $('.stoneArray').map(function (looop) {
            looop = looop + 1;

            if(looop == index) {

                defaultStone.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                    'color_id': $(this).data('color_id'),
                    'color_name': $(this).data('color_name')
                });
            } else {


                stone.push({
                    'id': $(this).val(),
                    'name': $(this).data('name'),
                    'color_id': $(this).data('color_id'),
                    'color_name': $(this).data('color_name')
                });
            }
        });

        $('#stoneRow').empty();

        let serial = 1;

        $('#stoneRow').append(
            `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ defaultStone[0].name +`
                        <input type="hidden" value="`+defaultStone[0].id+`" data-name="`+defaultStone[0].name+`" data-color_id="`+defaultStone[0].color_id+`" data-color_name="`+defaultStone[0].color_name+`" name="stoneArray[]" class="stoneArray">
                        <input type="hidden" value="`+defaultStone[0].name+`" name="styleNameArray[]" class="stoneNameArray">
                    </td>
                    <td>
                        `+ defaultStone[0].color_name +` &nbsp; <span class="badge badge-primary">Default</span><input type="hidden" value="`+ serial +`" id="defaultCheck" name="stoneDefaultCheck[]">
                        <input type="hidden" value="`+defaultStone[0].color_id+`" data-name="`+defaultStone[0].color_name+`" name="colorArray[]" class="colorArray">
                        <input type="hidden" value="`+defaultStone[0].color_name+`" name="colorNameArray[]" class="colorNameArray">
                    </td>
                    <td style="text-align: left"></td>
                </tr>
            `
        );

        serial++;

        for (let s = 0; s < stone.length; s++) {
            $('#stoneRow').append(
                `
                <tr>
                    <td style="text-align: center">`+ serial +`</td>
                    <td>
                        `+ stone[s].name +`
                        <input type="hidden" value="`+stone[s].id+`" data-name="`+stone[s].name+`" data-color_id="`+stone[s].color_id+`" data-color_name="`+stone[s].color_name+`" name="stoneArray[]" class="stoneArray">
                        <input type="hidden" value="`+stone[s].name+`" name="stoneNameArray[]" class="stoneNameArray">
                    </td>
                    <td>
                        `+ stone[s].color_name +`
                        <input type="hidden" value="`+stone[s].color_id+`" data-name="`+stone[s].color_name+`" name="colorArray[]" class="colorArray">
                        <input type="hidden" value="`+stone[s].color_name+`" name="colorNameArray[]" class="colorNameArray">
                    </td>
                    <td style="text-align: left"><button type="button" style="background: transparent; border: none" class="changeDefault" onclick="stoneChangeDefault(`+ serial +`)"><i class="fa fa-arrow-circle-up"></i> Default</button><button type="button" class=" remStyle" style="background: transparent; border: none"><i class="fa fa-trash text-danger"></i> Remove</button> </td>
                </tr>
            `
            );
            serial++;
        }
    }

    // Handle This Part Does not have Stone
    $('#noStone').on('click', function () {

        if($(this).prop('checked') == true) {
            $('#stone_type').val('').trigger('change');
            $('#stone_color').val('').trigger('change');
            $('#addStone').prop('disabled', true);
            $('#stone_type').prop('disabled', true);
            $('#stone_color').prop('disabled', true);
            $('#stoneRow').hide();
            $('.noStone').hide();
        } else {
            $('#addStone').prop('disabled', false);
            $('#stone_type').prop('disabled', false);
            $('#stone_color').prop('disabled', false);
            $('#stoneRow').show();
            $('.noStone').show();
        }
    });

    // Control Back Button
    $('#backForm').on('click', function () {

        let index = $('#Index').val();
        let type = $('#type_id').val();

        if (index == '8' && type != '108') {
            // Decrease Index back Button ONCLICK
            newIndex = Number(index) - 2;
        } else {
            // Decrease Index back Button ONCLICK
            newIndex = Number(index) - 1;
        }

        $('#Index').val(newIndex);
        // Load Base Layout
        base();

    });

    // Handle Do not add initial Quantity
    $('#noInventory').on('click', function () {

        if($(this).prop('checked') == true) {
            $("#part_location_id").val("");
            $("#part_location_input").val("");
            $('.inventoryFields').hide('slow');
        } else {
            $('.inventoryFields').show('slow');
        }
    });

    // $(document).ready(function () {
    //
    //     $('#part_id').val('32');
    //     $('#lang').val('english');
    //
    //     loadPartData();
    // });
    function loadPartData() {

        let part_id = $('#part_id').val();
        let lang = $('#lang').val();

        $.ajax({
            type: "get",
            url: "{{ route('part_store.detail') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'part': part_id,
                'lang': lang
            },
            success:function(response) {
                if (response.success) {
                    // Bsic Information Parse to Step 9
                    $('#category_data').text(response.detail.category.parent['name_in_'+response.lang]+' >> '+response.detail.category['name_in_'+response.lang]);
                    $('#part_type_data').text(response.detail.type['name_in_'+response.lang]);
                    $('#part_number_data').text(response.detail.part_no);
                    $('#part_description_data').text(response.detail.desc);
                    $('#sku_data').text(response.detail.sku);
                    $('#upc_data').text((response.detail.upc) ? response.detail.upc : 'Waiting for UPC Pool');
                    $('#part_uom_data').text(response.detail.uom);

                    // Classification Data Parse
                    $('#base_material_data').text(response.detail.base_material['name_in_'+response.lang]);
                    if (response.detail.metal_stamp) {
                        $('#metal_stamp_data').text(response.detail.metal_stamp['name_in_'+response.lang]);
                    }
                    $('#finish_type_data').text(response.detail.finish_type['name_in_'+response.lang]);
                    $('#detail_type_data').text(response.detail.detail_type['name_in_'+lang]);
                    if (response.detail.color) {
                        $('#detailColorRow').show('slow');
                        $('#detail_color_data').text(response.detail.color['name_in_'+lang]);
                    } else {
                        $('#detailColorRow').hide('slow');
                    }

                    $('#shape_data').text(response.detail.shape['name_in_'+lang]);

                    // Gender Data Parse
                    if (response.detail.genders) {
                        $('#genderList_data').empty();
                        for (let g = 0; g < response.detail.genders.length; g++) {

                            $('#genderList_data').append(response.detail.genders[g]['name_in_'+lang]+' , ');
                        }
                    }

                    // Style Data Parse
                    if (response.detail.styles) {
                        $('#styleList_data').empty();
                        let styleDefault;
                        for (let s = 0; s < response.detail.styles.length; s++) {
                            if (response.detail.styles[s].pivot['default'] == '1') {
                                styleDefault = '<span class="badge badge-primary">Default</span>';
                            } else {
                                styleDefault = '';
                            }

                            $('#styleList_data').append(
                                `
                                    <tr>
                                        <td>`+response.detail.styles[s]['name_in_'+lang]+`</td>
                                        <td>`+styleDefault+`</td>
                                    </tr>
                                `
                            );
                        }

                        if (response.detail.styles.length == '0') {

                            $('#styleList_data').append(
                                `
                                    <tr>
                                        <td>This part does not have style.</td>
                                        <td></td>
                                    </tr>
                                `
                            );
                        }
                    }

                    // Size and weight Data Parse
                    $('#length_data').text(response.detail.length);
                    $('#width_data').text(response.detail.width);
                    $('#height_data').text(response.detail.height);
                    $('#uom_length_data').text(response.detail.uom_length);
                    $('#weight_data').text(response.detail.weight+' '+response.detail.uom_weight);

                    // Show Inventory Table in Step 9
                    if(response.detail.type_id == '108') {
                        $('.inventoryTable').show();
                    }

                    // Stone List Data Parse
                    if (response.detail.stones) {
                        let defaultStone = '';
                        $('#stoneList_data').empty();
                        for (let sc = 0; sc < response.detail.stones.length; sc++) {

                            if (response.detail.stones[sc].default == '1') {
                                defaultStone = '<span class="badge badge-primary">Default</span>';
                            } else {
                                defaultStone = '';
                            }

                            $('#stoneList_data').append(
                                `
                                    <tr>
                                        <td>`+response.detail.stones[sc].type['name_in_'+lang]+` <span style="margin-left: 20px">`+response.detail.stones[sc].color['name_in_'+lang]+`</span></td>
                                        <td> `+defaultStone+`</td>
                                    </tr>
                                `
                            );
                        }

                        if (response.detail.stones.length == '0') {

                            $('#stoneList_data').append(
                                `
                                    <tr>
                                        <td>This part does not have Stone.</td>
                                        <td></td>
                                    </tr>
                                `
                            );
                        }
                    }

                    if(response.detail.continue_step > '8') {

                        if (response.schema.has_ring == 1) {
                            $('#ring_size_detail').show('slow');
                        }

                        if (response.schema.has_bangle == 1) {
                            $('#bangle_size_detail').show('slow');
                        }

                        if (
                            response.schema.has_guage == 1 &&
                            response.detail.category_id != '75' &&
                            response.detail.category_id != '32' &&
                            response.detail.category_id != '22'
                        ) {
                            $('#guage_detail').show('slow');
                        }

                        if (response.schema.has_thickness == 1) {
                            $('#thickness_detail').show('slow');
                        }
                    }

                    if (response.additional == 'yes') {
                        $('.additionalInformation').show();
                    } else {
                        $('.additionalInformation').hide();
                    }

                    // Additional Info Data Parse
                    if (response.detail.bangle)
                        $('#bangle_size_data').text(response.detail.bangle['name_in_'+lang]);

                    if (response.detail.ring)
                        $('#ring_size_data').text(response.detail.ring['name_in_'+lang]);

                    if (response.detail.guage)
                        $('#guage_data').text(response.detail.guage['name_in_'+lang]);

                    $('#thickness_data').text(response.detail.thickness);

                    // Factory Data Parse
                    $('#ppp_data').text(response.detail.ppp);

                    if (response.detail.quality)
                        $('#quality_data').text(response.detail.quality['name_in_'+lang]);

                    $('#p_cost_data').text(response.detail.p_cost);
                    $('#r_cost_data').text(response.detail.r_cost);

                    // // Inventory Data Parse
                    if(response.detail.loc)
                        $('#location_data').text(response.detail.loc.group.name+ '-' + response.detail.loc.name);
                    // $('#part_location_input').val(response.detail.loc.group.name+'-'+response.detail.loc.name);
                    // $('#parts-locations').append('<option value="'+response.detail.loc.group.name+'-'+response.detail.loc.name+'">');
                    $('#qty_data').text(response.detail.quantity);

                    if (response.detail.metal_stamp_id == '129') {
                        $('.s925DetailData').show('slow');
                        $('.s925_other_field').hide();
                        $('.s925_field').show();
                        $('#currency_data').text(response.detail.currency.symbol+' - '+response.detail.currency.name);
                        $('#exchange_rate_data').text(response.detail.exchange_rate);
                        $('#labor_cost_data').text(response.detail.labor_cost);
                        $('#silver_cost_data').text(response.detail.silver_cost);
                        $('#duty_data').text(response.detail.duty);
                        $('#unit_cost_data').text(response.detail.cost);

                    } else {
                        $('.s925DetailData').hide('slow');
                        $('.s925_field').hide();
                        $('.s925_other_field').show();
                        $('#unit_cost_data').text(response.detail.cost);
                    }

                    if($('#noInventory').prop('checked')) {

                        $('.inventoryData').hide();
                        $('.s925DetailData').hide();
                        $('.noInventoryRow').show();
                    } else if (response.detail.metal_stamp_id == '129') {

                        $('.noInventoryRow').hide();
                        $('.s925DetailData').show('slow');
                    } else {

                        $('.noInventoryRow').hide();
                        $('.inventoryData').show('slow');
                    }

                    // Vendor data Parse
                    $('#vendor_data').text(response.detail.vendor.account_no+' - '+response.detail.vendor.name);
                    $('#v_part_no_data').text(response.detail.vendor_part_no);
                    $('#vendor_uom_datas').text(response.detail.uom);
                    $('#vendor_uom_data').text(response.detail.uom);
                    $('#last_cost_data').text(response.detail.last_cost);
                }
            }
        })
    }

    // Edit Step wise
    function stepEdit(index) {
        // Parse New Index
        $('#Index').val(index);
        // Load Base Layout
        base();
    }

    async function review(index) {
        let location_input_text = $("#part_location_input").val();
        let res = await checkLocationAccuracy(location_input_text);

        // if(checkLocationAccuracy(location_input_text) == 'yes'){
        //     alert("yes i am here");
        //     return false;
        // }
        if (res) {
            savePartForm();
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('close');
            });

            setTimeout(function () {
                // Parse New Index
                $('#Index').val(index);
                // Load Base Layout
                base();
                //  Load Final Content
                loadPartData();
            }, 800);
        }



    }

    // Vendor Store Request
    $('#vendorStoreBtn').on('click', function () {

        var required_inputs = $('#name').filter('[required]:visible');
        var count = 0;

        for(var i = 0; i < required_inputs.length; i++){
            var ids = required_inputs[i].id;
            $('#error-'+ids).fadeOut('slow');
            $('#'+ids).css('border', '1px solid lightgrey');
            var vals = required_inputs[i].value;
            if(vals == ''){
                $('#error-'+ids).fadeIn('slow');
                count++;
                $('#'+ids).css('border', '1px solid red');
            }
        }

        if (count > 0) {
            setTimeout(function () {
                toastr['error'](
                    'Error! Some Required Fields are not valid.',
                    'Error!',
                    {
                        closeButton: true,
                        tapToDismiss: true
                    }
                );
            }, 2000);
            return false;
        }

        let formData = new FormData($('#vendorStoreForm')[0]);

        $.ajax({
            url:"{{ route('part.vendor_store') }}",
            data: formData,
            type:"post",
            processData:false,
            cache:false,
            contentType:false,
            success:function(response){
                if(response.success == true){
                    setTimeout(function () {
                        toastr['success'](
                            'Success! '+ response.message,
                            'Success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);

                    $('#createVendor').modal('hide');
                    $('#vendor').append('<option value="'+response.vendor.id+'">'+response.vendor.account_no+' - '+response.vendor.name+'</option>');
                    $('#vendor').val(response.vendor.id).trigger('change');

                } else if(response.alreadyExists == true) {

                    setTimeout(function () {
                        toastr['warning'](
                            'Vendor Already Exists',
                            'Warning!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else{

                    setTimeout(function () {
                        toastr['error'](
                            'Oh snap! something went wrong, please try again later..',
                            'error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000)
                }
            },
            error:function(e){

                setTimeout(function () {
                    toastr['error'](
                        'Oh snap! Some required fields are not valid.',
                        'error!',
                        {
                            closeButton: true,
                            tapToDismiss: true
                        }
                    );
                }, 2000);
            }
        });
    });

    function s925Calculation() {
        // Get Value for Calculation
        var exchangeRate = $('#exchange_rate').val();
        var laborCost = $('#labor_cost').val();
        var silverCost = $('#silver_cost').val();
        var duty = $('#duty').val();

        // calculate Silver Cost
        if (silverCost != '') {
            var costWithoutDuty = (Number(laborCost) + Number(silverCost)) / Number(exchangeRate);
            var finalDuty = Number(costWithoutDuty) * Number(duty) / 100;
            var unitCost = Number(costWithoutDuty) + Number(finalDuty);
            // get Gram Related Data
            var gram = $('#uom').val();
            var gramWeight = $('#weight').val();
            // If UOM WEIGHT not equal to gram
            if (gram != 'g') {
                unitCost = Number(gramWeight) * Number(unitCost);
            }

            // Parse Calculated Value to Last Cost Field
            $('#last_cost').val(unitCost.toFixed(2));
            $('#unit_cost').val(unitCost.toFixed(2));
        } else {
            unitCost = $('#unit_cost').val();

            // Parse Calculated Value to Last Cost Field
            $('#last_cost').val(unitCost);
        }

    }

    // check length for length value
    $("#length").on("keyup focusout",function(){
        let categroy = $('#category_id').find(':selected').data('cat_parent');

        if (categroy != '2' && categroy != '14') {
            let value=$(this).val();
            if(value % 1 != 0){
                $("#length-digits").removeClass("d-none");
                $(this).val(value.substring(0,2));
            }
            else{
                $("#length-digits").addClass("d-none");
            }
        }
        else{
            let value=$(this).val();
            number_to_array = value.split(".");
            int = number_to_array[0];
            dec = number_to_array[1];
            if(dec && dec.length>2){
                $("#length-digits").removeClass("d-none");
                $(this).val(int+"."+dec.substring(0,2));
            }
            else{
                $("#length-digits").addClass("d-none");
            }
        }
    });

    $('#base_material').on('change', function() {
        var optionSelected = $(this).find("option:selected");
        var baseMaterial = optionSelected.val();

        getMetalStamp(baseMaterial);
    });

    function getMetalStamp(base, metalStamp) {

        $.ajax({
            type: "get",
            url: "{{ route('getMetalStamp') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                base: base
            },
            success: function(response) {
                if (response.success) {

                    let lang = $('#lang').val();

                    $('#metal_stamp').empty();

                    $('#metal_stamp').empty('<option value="" selected disabled>Select Option</option>');

                    let selected = '';
                    for (let i = 0; i < response.data.length; i++) {
                        if (metalStamp != '') {
                            selected = (response.data[i].metals[0].id == metalStamp) ? 'selected' : '';
                        }

                        $('#metal_stamp').append('<option value="'+response.data[i].metals[0].id+'" '+selected+'>'+response.data[i].metals[0]['name_in_'+lang]+'</option>');
                    }
                }
            }
        })
    }

    function generateGendersDropDown(response){
        let genders=response.alteredGenders;
        $("#gender").empty();

        $("#gender").append('<option value="" >Select an option</option>');
        genders.forEach(gender=>{
            $("#gender").append('<option value="'+gender.id+'" >'+gender.name_in_english+'</option>');
        });

    }

    function deleteGender(gender_id,part_id) {
        $.ajax({
            url: "{{ route('delete.gender') }}",
            method: "post",
            data: {
                part_id: part_id,
                gender_id: gender_id
            },
            success: function (response) {
                if (response.success == true) {
                    generateGendersDropDown(response);
                    toastr.success(response.msg);
                } else if (response.success == false) {
                    toastr.error(response.msg);
                }
            }
        });
    }

    function setDefaultGender(gender_id, part_id,index) {
        $.ajax({
            url: "{{ route('setDefault.gender') }}",
            method: "post",
            data: {
                part_id: part_id,
                gender_id: gender_id
            },
            success: function (response) {
                if (response.success == true) {
                    genderChangeDefault(index)
                    toastr.success(response.msg);
                } else if (response.success == false) {
                    toastr.error(response.msg);
                }
            }
        });
    }

    $('#category_id').on('change', function () {
        var key;
        var value;
        var optionSelected = $(this).find("option:selected");
        var catName=optionSelected.attr('data-cat_name');
        var subCatName=optionSelected.attr('data-sub-cat');
        if(catName== "Anklets"||catName== "Bracelets"||catName=="Brooches"||catName=="Necklaces"||catName=="Pendants"||catName=="Rosaries"||catName=="Watches"||catName=="Rings - Individual"||(catName=="Bangles" &&subCatName=="Individual")){
            value="Each (ea)";
            key="ea";
        }
        else if((catName=="Bangles" &&subCatName=="Set")||catName=="Necklace Sets"||catName=="Rings - Duo"||catName=="Sets (E/P)" ){
            value="Package (pkg)";
            key="pkg";
        }
        else if((catName=="Bangles" && subCatName=="Trio")||catName=="Rings - Trio"){
            value="Trio (tri))";
            key="tri";
        }
        else if((catName=="Bangles" && subCatName=="Dozen")){
            value="Dozen (dz)";
            key="dz";
        }
        else if((catName=="Bangles" && subCatName=="Semanario")){
            value="Semanario (sem)";
            key="sem";
        }
        else if(catName=="Earrings"||catName=="Hoops"){
            value="Pair (pr)";
            key="pr";
        }
        else{
            value="Each (ea)";
            key="ea";
        }
        let selected = 'selected' ;

        $('#uom').append('<option value="'+key+'" '+selected+'>'+value+'</option>');
    });

    $('#category_id').on('change', function () {
        var key;
        var value;
        var optionSelected = $(this).find("option:selected");
        var catName=optionSelected.attr('data-cat_name');
        if(catName== "Anklets"||catName== "Bracelets"||catName=="Necklace Sets"||catName=="Necklaces"||catName=="Rosaries"){
            value="Inches (in)";
            key="in";
        }
        else{
            value="Millimeter (mm)";
            key="mm";
        }
        let selected = 'selected' ;

        $('#uom_weight').append('<option value="'+key+'" '+selected+'>'+value+'</option>');
    })

    $("#width").on("keyup focusout",function(){
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#width-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#width-digits").addClass("d-none");
        }
    });

    $("#weight").on("keyup focusout",function(){
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#weight-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#weight-digits").addClass("d-none");
        }
    });

    $("#height").on("keyup focusout",function(){
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#height-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#height-digits").addClass("d-none");
        }
    });

    $("#p_cost").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#p-cost-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#p-cost-digits").addClass("d-none");
        }
    });

    $("#r_cost").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#r-cost-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#r-cost-digits").addClass("d-none");
        }
    });

    $("#quantity").on("keyup focusout",function () {
        var uom=$('#inventoryUOM').val();
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(uom=="g"){
            if(dec && dec.length>2){
                $("#quantity-digits").removeClass("d-none");
                $(this).val(int+"."+dec.substring(0,2));
            }
            else{
                $("#quantity-digits").addClass("d-none");
            }
        }else{
            if(dec && dec.length>0){
                $("#quantity-decimal").removeClass("d-none");
                $(this).val(int);
            }
            else{
                $("#quantity-decimal").addClass("d-none");
            }
        }

    });

    $("#last_cost").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#last_cost-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#last_cost-digits").addClass("d-none");
        }
    });

    $("#exchange_rate").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#exchange_rate-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#exchange_rate-digits").addClass("d-none");
        }
    });

    $("#labor_cost").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#labor_cost-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#labor_cost-digits").addClass("d-none");
        }
    });

    $("#silver_cost").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#silver_cost-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#silver_cost-digits").addClass("d-none");
        }
    });

    $("#duty").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#duty-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#duty-digits").addClass("d-none");
        }
    });

    $("#thickness").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#thickness-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#thickness-digits").addClass("d-none");
        }
    });

    $("#unit_cost").on("keyup focusout",function () {
        let value=$(this).val();
        number_to_array = value.split(".");
        int = number_to_array[0];
        dec = number_to_array[1];
        if(dec && dec.length>2){
            $("#unit_cost-digits").removeClass("d-none");
            $(this).val(int+"."+dec.substring(0,2));
        }
        else{
            $("#unit_cost-digits").addClass("d-none");
        }
    });

    // Virtual Part Vendor Selection
    $('#vendor').on('change', function() {
        var optionSelected = $(this).find("option:selected");
        var vendor = optionSelected.val();

        if (vendor == '80') {

            $('#category_id').val('558').change();
            $('#category_id').attr('disabled', true);
            $('#type_id').val('556').change();
            $('#type_id').attr('disabled', true);
            $('#uom').val('pkg').trigger('change');
            $('#uom').attr('disabled', true);
        } else if (vendor == '81') {

            $('#category_id').val('557').change();
            $('#category_id').attr('disabled', true);
            $('#type_id').val('556').change();
            $('#type_id').attr('disabled', true);
            $('#uom').val('pkg').trigger('change');
            $('#uom').attr('disabled', true);
        } else {

            $('#category_id').val('').change();
            $('#category_id').attr('disabled', false);
            $('#type_id').val('108').change();
            $('#type_id').attr('disabled', false);
            $('#uom').val('ea').trigger('change');
            $('#uom').attr('disabled', false);
        }
    });

    // Virtual Part Step 2 Search
    $(document).on('click', '#searchVirtualPart', function () {

        let part_no = $('#v_part_no').val();
        let part_description = $('#v_part_description').val();
        let alreadyPart = $('#vPart').val();

        $.ajax({
            type: "get",
            url: "{{ route('virtualPart.getPart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                part_no: part_no,
                part_description: part_description,
                alreadyPart: alreadyPart
            },
            success: function(response) {
                if (response.success) {

                    $('#virtualPartBody').empty();

                    if (response.parts.length == '0') {

                        toastr.error('part Not Found');
                        return false;
                    }

                    $('#addPartVirtual').modal('show');
                    $('#v_part_no').val('');
                    $('#v_part_description').val('');

                    for (let i = 0; i < response.parts.length; i++) {

                        $('#virtualPartBody').append(
                            `
                                <tr id="partRow`+response.parts[i].id+`">
                                    <td><input type="checkbox" class="vPart_data" name="virtualPart[]" data-vPart_id="`+response.parts[i].id+`" data-vPart_desc="`+response.parts[i].desc+`" data-vPart_no="`+response.parts[i].part_no+`" value="`+response.parts[i].id+`"></td>
                                    <td><img src="https://milanus.aleem.dev/images/internal100/`+response.parts[i].part_no+`/Def/50/50" width="50px" height="50px"></td>
                                    <td>`+response.parts[i].part_no+`</td>
                                    <td>`+response.parts[i].desc+`</td>
                                    <td>`+response.parts[i].category.parent.name_in_english+` - `+response.parts[i].category.name_in_english+`</td>
                                    <td>`+response.parts[i].last_cost+`</td>
                                </tr>
                            `
                        );
                    }
                }
            }
        })
    });

    $(document).on('click', '.vPart_data', function (e) {

        let vPart = $(this).data('vpart_id');
        let vPart_no = $(this).data('vpart_no');
        let vPart_desc = $(this).data('vpart_desc');

        $('#error-partBody').hide();

        $('#virtualConfirmPartBody').append(
            `
                <tr>
                    <td>
                        <input type="number" class="form-control" name="vQty[]" id="vQty`+vPart+`" placeholder="Enter Qty" required>
                        <div style="display: none" id="error-vQty`+vPart+`"><span class="error text-danger">Price Kit is Required.</span></div>
                    </td>
                    <td><img src="https://milanus.aleem.dev/images/internal100/`+vPart_no+`/Def/50/50" width="50px" height="50px"></td>
                    <td>
                        <input type="hidden" name="vPart[]" value="`+vPart+`">
                        `+vPart_no+` - `+vPart_desc+`
                    </td>
                    <td><a href="javascript:void(0)" class="text-gray-400 text-hover-danger remCF">
                        <i class="fa fa-trash"></i>
                            Remove
                        </a>
                    </td>
                </tr>
            `
        );

        e.preventDefault();
        var row = $(this).closest('tr');
        row.hide(500, function(){
            this.remove();
        });

        var table = document.getElementById("kitPartTable");
        var tbodyRowCount = table.tBodies[0].rows.length; // 3

        if (tbodyRowCount == '1') {

            $('#addPartVirtual').modal('hide');
        }

    });

    // Part Search Modal Inner search Deal
    $(document).ready(function() {

        // Search all columns
        $('#txt_searchall').keyup(function () {
            // Search Text
            var search = $(this).val();

            // Hide all table tbody rows
            $('.searchPartTable tbody tr').hide();

            // Count total search result
            var len = $('.searchPartTable tbody tr:not(.notfound) td:contains("' + search + '")').length;

            if (len > 0) {
                // Searching text in columns and show match row
                $('.searchPartTable tbody tr:not(.notfound) td:contains("' + search + '")').each(function () {
                    $(this).closest('tr').show();
                });
            } else {
                $('.notfound').show();
            }

        });
    });


    // Load Virtual Part Review Page Data
    function virtualLoadData() {

        let part_id = $('#part_id').val();
        let lang = $('#lang').val();

        $.ajax({
            type: "get",
            url: "{{ route('virtual.reviewData') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'part': part_id,
                'lang': lang
            },
            success: function (response) {
                if (response.success) {

                    $('#v_part').text(response.detail.part_no);
                    $('#v_description').text(response.detail.desc);
                    $('#v_sku').text(response.detail.sku);
                    $('#v_upc').text(response.detail.upc);
                    $('#c_part_type').text(response.detail.type['name_in_'+response.lang]);
                    $('#v_part_uom').text(response.detail.uom);
                    $('#v_category').text(response.detail.category.parent['name_in_'+response.lang]+' >> '+response.detail.category['name_in_'+response.lang]);

                    $('#v_title').text(response.detail.title);
                    $('#v_description_data').html(response.detail.description);

                    $('#v_parts_data').empty();

                    for (var i = 0; i < response.detail.virtual.length; i++) {

                        let qty = (response.detail.virtual[i].qty != null) ? response.detail.virtual[i].qty : "";

                        $('#v_parts_data').append(
                            `
                                <tr>
                                    <td>`+response.detail.virtual[i].v_part.part_no+` - `+response.detail.virtual[i].v_part.desc+`</td>
                                    <td>`+ qty +`</td>
                                </tr>
                            `
                        );
                    }
                }
            }
        })
    }

    $("#virtualConfirmPartBody").on('click', '.remCF', function() {
        $(this).parent().parent().remove();
    });

    $('#addResultPool').on('click', function () {

        let category = $('#result_pool').find(":selected").data('pool_category');
        let pool_id = $('#result_pool').find(":selected").val();
        let pool_name = $('#result_pool').find(":selected").text();

        $('#error-vPool').hide();

        $('#virtualConfirmPoolBody').append(
            `
                <tr>
                    <td>
                        <input type="hidden" name="vPool[]" id="vPool" required value="`+pool_id+`">
                        <input type="text" class="form-control" value="`+pool_name+`" readonly>
                    </td>
                    <td><a href="javascript:void(0)" class="text-gray-400 text-hover-danger remCFF">
                        <i class="fa fa-trash"></i>
                            Remove
                        </a>
                    </td>
                </tr>
            `
        );

    })

    $("#virtualConfirmPoolBody").on('click', '.remCFF', function() {
        $(this).parent().parent().remove();
    });


</script>
@include('custom.part_location_script_js')
@include('custom.check_location_accuracy')
