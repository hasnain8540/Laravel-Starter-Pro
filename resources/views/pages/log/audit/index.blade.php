<x-base-layout>

    @section('pageHeader', 'Audit Logs')
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.log.audit._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</x-base-layout>
