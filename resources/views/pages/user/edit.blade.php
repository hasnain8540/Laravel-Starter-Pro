<x-base-layout>

    @section('pageHeader', 'Edit User')

    @section('innerLinkBreadCumb')

        {!!innerBreadCrum($breadCumb)!!}

    @endsection

    @section('headerToolBox')
        <div class="col-5">
            <a href="{{route('user.index') }}" class=" mx-6 btn btn-sm btn-primary float-end text-nowrap"><i class="fs-4 bi bi-arrow-left"></i>Back</a>
        </div>
    @endsection
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-fluid">
                    <!--begin::Form-->
                    <div id="kt_ecommerce_add_product_form"
                        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
                        data-kt-redirect="/metronic8/demo8/../demo8/apps/ecommerce/catalog/products.html">
                        <input type="hidden" id="user" value="{{ $user->id }}">
                        <!--begin::Main column-->
                        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <!--begin:::Tabs-->
                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">

                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 active tab" data-bs-toggle="tab"
                                        href="#kt_ecommerce_add_product_userInformationEditPane">User Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 tab" data-bs-toggle="tab"
                                        href="#kt_ecommerce_add_product_userLocationGroupEditPane">Location Group</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 tab" data-bs-toggle="tab"
                                        href="#kt_ecommerce_add_product_userRoleEditPane" id="partTab">Role (User Permission)</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 tab" data-bs-toggle="tab"
                                        href="#kt_ecommerce_add_product_userLogsEditPane" id="userLogTab">Logs</a>
                                </li>
                            </ul>
                            <!--end:::Tabs-->
                            <!--begin::Tab content-->
                            <div class="tab-content">
                                <!--begin::Tab General-->
                                <div class="tab-pane fade active show" id="kt_ecommerce_add_product_userInformationEditPane" role="tab-panel">
                                    @include('pages.user.EditPanes.user-info')
                                </div>
                                <!--end::Tab General-->
                                <!--begin::Tab Classification-->
                                <div class="tab-pane fade" id="kt_ecommerce_add_product_userLocationGroupEditPane" role="tab-panel">
                                    @include('pages.user.EditPanes.user-location-groups')
                                </div>
                                <!--end::Tab Classification-->
                                <!--begin::Tab Parts-->
                                <div class="tab-pane fade" id="kt_ecommerce_add_product_userRoleEditPane" role="tab-panel">
                                    @include('pages.user.EditPanes.user-role')
                                </div>
                                <!--end::Tab Parts-->
                                <!--begin::Tab Styles-->
                                <div class="tab-pane fade" id="kt_ecommerce_add_product_userLogsEditPane" role="tab-panel">
                                    @include('pages.user.EditPanes.user-logs')
                                </div>
                                <!--end::Tab Styles-->
                            </div>
                            <!--end::Tab content-->

                        </div>
                        <!--end::Main column-->
                        <div></div>
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Post-->
        </div>
        <!--end::Content-->

    <!-- begin::Detach Role Modal -->
    @include('pages.user.EditPanes.detachRole')
    <!-- end::Detach Role Modal -->

    @section('scripts')
        {{-- Begin::Cutom Script --}}
        {{-- @include('custom.init_js') --}}
        @include('custom.user_js')
        {{-- End::Cutom Script --}}

        <script src="{{ asset('js/paginate.js') }}"></script>

    @endsection
</x-base-layout>
