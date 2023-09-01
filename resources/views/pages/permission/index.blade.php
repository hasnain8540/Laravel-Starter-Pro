<x-base-layout>

    @section('pageHeader', 'Permissions')
    <!--begin::Card-->
    <div class="card">
        <!-- begin::Card header -->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-datatable-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Permissions" />
                </div>
                <!--end::Search-->
            </div>
            <div class="card-toolbar">
                <!--end::Dropdown-->
                <!--begin::Button-->
                @can('create permission')
                    <a href="{{ route('permission.create') }}" class="btn btn-primary font-weight-bold mr-2 btn-sm">
                        <span class="svg-icon svg-icon-md">
                            <i class="fa fa-plus"></i>
                        </span> Create
                    </a>
                @endcan
                <!--end::Button-->
            </div>
        </div>
        <!-- end::Card Header -->
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.permission._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    <!--begin::Destroy Permission Modal-->
    @include('pages.permission.destroy')
    <!--end::Destroy Permission Modal-->
</x-base-layout>
