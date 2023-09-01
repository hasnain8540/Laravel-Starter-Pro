{{--<form class="form" method="post" id="user_role_form">--}}
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Roles</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="form-group mt-5">
                    <form method="post" action="{{ route('userRole.attach',['id'=>$user->id]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="role">Role <b class="text-danger">*</b></label>
                                <select class="form-control searchable-dropdown" id="role" name="role" required>
                                    <option value="" selected disabled>Select Option</option>
                                    @foreach($role as $r)
                                        <option value="{{ $r->id }}" @isset($user->role_id) @if($r->id == $user->role_id) selected @endif
                                            @endisset>{{ ucwords($r->name) }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger">@error('role'){{ $message }} @enderror</div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary mt-8"><i class="fa fa-plus"></i> Attach</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="part-edit-stone-table">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-45px" tabindex="0" aria-controls="kt_ecommerce_report_shipping_table" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="">#</th>
                            <th class="" tabindex="0" aria-controls="kt_ecommerce_report_shipping_table" rowspan="1" colspan="1" aria-label="Shipping Type: activate to sort column ascending" style="">Role</th>
                            <th class="w-200px" tabindex="0" aria-controls="kt_ecommerce_report_shipping_table" rowspan="1" colspan="1" aria-label="Shipping ID: activate to sort column ascending" style="">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold text-black">
                            @foreach($userRole as $ur)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($ur->name) }}</td>
                                    <td><a href="#" class="text-gray-400 text-hover-danger detachUserRole" data-bs-toggle="modal" data-bs-target="#detachRole" data-user_id="{{ $user->id }}" data-role_id="{{ $ur->id }}"><i class="fa fa-link"></i> Detach</a> </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- form end inside form buttons-->
    <div class="d-flex justify-content-end mt-5">
        <!--begin::Button-->
        <a href="{{ url()->previous() }}"
           id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Close</a>
        <!--end::Button-->
        <!--begin::Button-->
{{--        <button type="submit" id="saveEditForm" class="btn btn-primary">--}}
{{--            Save Changes--}}
{{--        </button>--}}
        <!--end::Button-->
    </div>
{{--</form>--}}
