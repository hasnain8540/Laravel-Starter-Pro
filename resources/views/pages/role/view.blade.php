<x-base-layout>

    @section('pageHeader', 'View Role')
    @section('innerLinkBreadCumb')
        {!!innerBreadCrum($breadCumb)!!}
    @endsection
    @section('headerToolBox')
        <div>
            <a href="{{route('role.index') }}" class=" mx-12 btn btn-sm btn-primary float-end text-nowrap"><i
                    class="fs-4 bi bi-arrow-left"></i>Back</a>
        </div>
@endsection
<!--begin::Card-->
    <div class="card">
        <!-- begin::Card header -->
        <div class="card-header flex-wrap pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"> {{ __('Role Detail') }}</h3>
            </div>
        </div>
        <!-- end::Card Header -->
        <!--begin::Card body-->
        <div class="card-body pt-6">
            <table class="table align-middle table-row-dashed " >
                <!--begin::Table body-->
                <tbody class="">
                <tr>
                    <!--begin::Name-->
                    <td><b>Name :</b></td>
                    <!--end::Name-->
                    <!--begin::Name=-->
                    <td>{{ ucfirst($detail->name) }}</td>
                    <!--end::Name=-->
                </tr>
                <tr></tr>
                </tbody>
            </table>

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    <!--begin::Card-->
    <div class="card mt-10">
        <!-- begin::Card header -->
        <div class="card-header flex-wrap pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"> {{ __('Attached Permission') }}</h3>
            </div>
        </div>
        <!-- end::Card Header -->
        <!--begin::Card body-->
        <div class="card-body pt-6">
            <table class="table align-middle table-row-dashed fs-6 gy-5 kt_table" id="kt_customers_table">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="text-start fs-7 text-uppercase gs-0"> #</th>
                    <th class="min-w-80px">Permission</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-bold text-gray-600">
                @foreach($attached as $l)
                    <tr>
                        <!--begin::S#-->
                        <td>{{ $loop->iteration }}</td>
                        <!--end::S#-->
                        <!--begin::module name-->
                        <td>{{ ucwords($l->permission) }}</td>
                        <!--end::module name-->
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
