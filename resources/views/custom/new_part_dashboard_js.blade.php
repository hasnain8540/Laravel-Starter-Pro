<script>
    // document::readyStart
    $(function () {
        // part dashboard search
        $(document).on('submit', '#search_form_part', function () {
            event.preventDefault();
            let formData = $("#search_form_part").serialize();
            $.ajax({
                url: "{{ route('part.search.dashboard') }}",
                method: "get",
                data: formData,
                success: function (response) {
                    if(response.success == true) {
                       
                        let parts = response.data;
                        let partRow = '';
                        // paginate
                        
                        // total parts count
                        let totalParts=parts.length;
                        $("#recordsFound").empty();
                        let countHtml=`
                        <h3 class="fw-bolder me-5 my-1">${totalParts} Items Found
                        <span class="text-gray-400 fs-6">by Recent Updates ↓</span></h3>
                        `;
                        $("#recordsFound").append(countHtml);
                        // row append
                        $("#cards-pane").empty();
                        parts.forEach(part => {
                            partRow = `<div class="row g-6 g-xl-9">
                                <!--begin::Col-->
                                <div class="col-md-12 col-xxl-12">
                                    <!--begin::Card-->
                                    <div class="card mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">${part.desc}</span>
                                                <span class="text-primary fw-bold fs-4">${part.part_no} 
                                                    <span class="text-muted fs-7">(${part.sku})</span>
                                                </span>
                                            </h3>
                                            <div class="card-toolbar">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-users"></i>Family</a> &nbsp;&nbsp;
                                                <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-bars"></i>Options</a>
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table align-middle gs-0 gy-4">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr class="fw-bolder text-muted bg-light">
                                                            <th class="ps-4 w-150px">Image</th>
                                                            <th class="min-w-250px">Inventory</th>
                                                            <th class="min-w-180px">Part Info</th>
                                                            <th class="min-w-200px">Classification</th>
                                                            <th class="">Others</th>

                                                        </tr>
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align: top;">
                                                                <span class="badge badge-secondary badge-lg w-100 flex-center fs-7 mb-2 border border-gray-400 border-dashed">Class D</span>
                                                                <div class="symbol symbol-150px border border-gray-400 border-dashed">
                                                                    <div class="symbol-label" style="background-image:url(https://webcenter.space/images/internal75/125410/def/600/600/125410_Def.jpg?refresh=1649188762)"></div>
                                                                </div>
                                                                <span class="badge badge-secondary badge-lg w-100 flex-center fs-6 border border-gray-400 border-dashed">$ 5.95</span>
                                                            </td>
                                                            <td style="vertical-align: top;">
                                                                <div>
                                                                    <table class="table table-rounded table-striped border gy-0 gs-3">
                                                                        <thead>
                                                                            <tr class="fw-bold fs-7 text-gray-800 border-bottom border-gray-200">
                                                                                <th>Group</th>
                                                                                <th>Location</th>
                                                                                <th>Qty</th>
                                                                                <th>Bin</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>`;
                                                                let inventories = part.inventories;
                                                                inventories.forEach(inventory => {
                                                                    partRow += `<tr>
                                                                                <td>${inventory.location.group.name}</td>
                                                                                <td>${inventory.location.name}</td>
                                                                                <td>${inventory.balance}</td>
                                                                                <td>${inventory.balance}</td>
                                                                                </tr>`;
                                                                });
                                                            
                                                             partRow += `</tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: top;">
                                                                <div>
                                                                    <span class="badge badge-light-primary fs-7 mb-2 fw-bold">Active</span>
                                                                    <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">UOM</a>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.uom}</span>
                                                                    <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Dimension</a>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.length ? part.length : ''} x ${part.width ? part.width : ''} x ${part.height ? part.height : ''} x ${part.uom_length ? part.uom_length : ''}</span>
                                                                    <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Weight</a>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.weight ? part.weight+' ': '' }${part.uom_weight ? part.uom_weight :'' }</span>
                                                                    <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Additional Info</a>
                                                                    <span class="text-dark fw-bold d-block mb-0 fs-7">Size 6</span>
                                                                    <span class="text-dark fw-bold d-block mb-0 fs-7">Gauge ${part.guage ? part.guage.name_in_english: ''}</span>
                                                                
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: top;">
                                                                <div>
                                                                    <span class="text-muted text-hover-primary d-block mb-0 fs-8">Category</span>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.category.parent.name_in_english} &gt;&gt; ${part.category.name_in_english}</span>
                                                                    <span class="text-muted text-hover-primary d-block mb-0 fs-8">Base Material</span>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.base_material ? part.base_material.name_in_english : ''}</span>
                                                                    <span class="text-muted text-hover-primary d-block mb-0 fs-8">Metal Stamp</span>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.metal_stamp ? part.metal_stamp.name_in_english : ''}</span>
                                                                    <span class="text-muted text-hover-primary d-block mb-0 fs-8">Finish Type</span>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.finish_type ? part.finish_type.name_in_english : ''}</span>
                                                                    <span class="text-muted text-hover-primary d-block mb-0 fs-8">Detail Type</span>
                                                                    <span class="text-dark fw-bold d-block mb-1 fs-7">${part.detail_type ? part.detail_type.name_in_english : '' }</span>
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: top;">
                                                                <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Stones</a>
                                                                <span class="text-dark fw-bold d-block mb-1 fs-7">
                                                            `;
                            // stones
                            let stones = part.stones;
                            stonesCount = stones.length;
                            stones.forEach(stone => {
                                if (stone.default == 1) {
                                    partRow +=
                                        `${stone.type.name_in_english} (${stone.color.name_in_english})`
                                    if (stonesCount > 1) {
                                        partRow += `<b> +</b>`;
                                    }
                                }
                                partRow += `</span>`;
                            });
                            partRow += `<a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Styles</a>
                                                                <span class="text-dark fw-bold d-block mb-1 fs-7">`
                            // styles
                            let styles = part.styles;
                            let styleCount = styles.length;
                            styles.forEach(style => {
                                if (style.pivot.default == 1) {
                                    partRow += `${style.name_in_english}`
                                    if (styleCount > 1) {
                                        partRow += `<b> +</b>`;
                                    }
                                }
                            });

                            partRow += `</span>
                                                                <hr class="mb-1" style="margin-top: 0px;">
                                                                <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Vendor</a>
                                                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.vendor.id} - ${part.vendor.name}</span>
                                                                <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Vendor #</a>
                                                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.vendor.name} - ${part.vendor.id}</span>
                                                                <a href="#" class="text-muted text-hover-primary d-block mb-0 fs-8">Last Cost</a>
                                                                <span class="text-dark fw-bold d-block mb-1 fs-7">${part.last_cost ? '$'+ '' +part.last_cost : ''}</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table container-->
                                        </div>
                                        <!--begin::Body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end::Col-->
                            </div>`;
                            $("#cards-pane").append(partRow);
                        });
                       
                    } else if(response.success == false) {
                        toastr.error(response.msg);
                    }
                }
            });



        });
        // document::readySEnd
    });

</script>
