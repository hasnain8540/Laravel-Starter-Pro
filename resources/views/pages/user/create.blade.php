<x-base-layout>

    @section('pageHeader', 'Create User')

    @section('innerLinkBreadCumb')

        {!!innerBreadCrum($breadCumb)!!}

    @endsection

    @section('headerToolBox')
        <div class="col-5">
            <a href="{{route('user.index') }}" class=" mx-6 btn btn-sm btn-primary float-end text-nowrap"><i class="fs-4 bi bi-arrow-left"></i>Back</a>
        </div>
    @endsection
    <!--begin::Card-->
    <div class="card">
        <form method="post" action="{{ route('user.store') }}" id="user_create_form">
        @csrf
        <!-- begin::Card header -->
            <div class="card-header flex-wrap pt-6 pb-0">
                <div class="card-title">
                    <h2 class="card-label">{{ __('Create User') }} </h2>
                </div>
            </div>
            <!-- end::Card Header -->
            <!--begin::Card body-->
            <div class="card-body pt-6">
                @include('pages.user._form')
            </div>
            <div class="card-footer">
                <div class="card-toolbar" style="float: right">
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <button type="submit" id="create_user_btn" class="btn btn-sm btn-primary font-weight-bold mb-5">
                        Save Changes
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </form>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    @section('scripts')
        {{-- Begin::Cutom Script --}}
        {{-- @include('custom.init_js') --}}
        @include('custom.user_js')
        {{-- End::Cutom Script --}}
    @endsection
</x-base-layout>
