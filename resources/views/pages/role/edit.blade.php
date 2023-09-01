<x-base-layout>

    @section('pageHeader', 'Edit Role')

    @section('innerLinkBreadCumb')

        {!!innerBreadCrum($breadCumb)!!}

    @endsection

    @section('headerToolBox')
        <div class="col-5">
            <a href="{{route('role.index') }}" class=" mx-6 btn btn-sm btn-primary float-end text-nowrap"><i
                    class="fs-4 bi bi-arrow-left"></i>Back</a>
        </div>
@endsection
<!--begin::Card-->
    <div class="card">
        <form method="post" action="{{ route('role.update',['id'=>$role->id]) }}" id="kt_form_validate">
        @csrf
        <!-- begin::Card header -->
            <div class="card-header flex-wrap pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">{{ __('Edit Role') }} </h3>
                </div>
            </div>
            <!-- end::Card Header -->
            <!--begin::Card body-->
            <div class="card-body pt-6">
                @include('pages.role._form')
            </div>
            <div class="card-footer">
                <div class="card-toolbar" style="float: right">
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold mb-5">
                         Save Changes
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </form>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</x-base-layout>
