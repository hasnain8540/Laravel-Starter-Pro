<x-base-layout>

@section('pageHeader', 'Storage Setting')
<!--begin::Card-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush py-4">
            <form method="post" action="{{ route('storage.update') }}" id="kt_form_validate">
            @csrf
            <!-- begin::Card header -->
                <div class="card-header flex-wrap pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('Api Settings') }} </h3>
                    </div>
                </div>
                <!-- end::Card Header -->
                <!--begin::Card body-->
                <div class="card-body pt-6">
                    @include('pages.storageSetting._form')
                </div>

            </form>
            <!--end::Card body-->
        </div>
    </div>

    <div class="d-flex flex-column pt-10">
        <div class="card card-flush py-4">
            <form method="post" action="{{ route('storage.shippingMarkup') }}" id="kt_form_validate">
            @csrf
            <!-- begin::Card header -->
                <div class="card-header flex-wrap pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('Shipping MarkUp') }} </h3>
                    </div>
                </div>
                <!-- end::Card Header -->
                <!--begin::Card body-->
                <div class="card-body pt-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label" for="Shipping Mark up">Shipping Markup<b
                                        class="text-danger">*</b></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" step="any" class="form-control"
                                           value="{{number_format(@$shippingMarkup->shipping_markup,2,'.','')}}"
                                           aria-label="Amount (to the nearest dollar)"
                                           name="shipping_markup" placeholder="Enter Shipping Mark up" required>
                                </div>
                            </div>
                            <div class="row pe-6">
                                <div class="col-md-12 ">
                                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold mt-5"
                                            style="float: right"> Update
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

            </form>
            <!--end::Card body-->
        </div>
    </div>

    @section('script')
        @include('custom.init_js')
    @endsection
</x-base-layout>


