<x-base-layout>

    @section('pageHeader', 'View User')
    @section('innerLinkBreadCumb')
        {!!innerBreadCrum($breadCumb)!!}
    @endsection
    @section('headerToolBox')
        <div>
            <a href="{{route('user.index') }}" class=" mx-12 btn btn-sm btn-primary float-end text-nowrap"><i
                    class="fs-4 bi bi-arrow-left"></i>Back</a>
        </div>
@endsection
<!--begin::Card-->
    <div class="card">
        <!-- begin::Card header -->
        <div class="card-header flex-wrap pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"> {{ __('User Detail') }}</h3>
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
                    <td><b>First Name :</b></td>
                    <!--end::Name-->
                    <!--begin::Name=-->
                    <td>{{ ucfirst($detail->first_name) }}</td>
                    <!--end::Name-->
                    <!--begin::Name-->
                    <td><b>Last Name :</b></td>
                    <!--end::Name-->
                    <!--begin::Name=-->
                    <td>{{ ucfirst($detail->last_name) }}</td>
                    <!--end::Name-->
                </tr>
                <tr>
                    <!--begin::Email-->
                    <td><b>Email :</b></td>
                    <!--end::Email-->
                    <!--begin::Email-->
                    <td>{{ ucfirst($detail->email) }}</td>
                    <!--end::Email-->
                    <!--begin::Role Name-->
                    <td><b>Role :</b></td>
                    <!--end::Role Name-->
                    <!--begin::Role Name-->
                    <td>{{ ucfirst($detail->role) }}</td>
                    <!--end::Role Name-->
                </tr>
                <tr></tr>
                </tbody>
            </table>

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
