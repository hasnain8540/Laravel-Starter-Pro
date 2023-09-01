<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" for="first_name">First Name <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                value="@isset($user->first_name){{ $user->first_name }}@endisset {{ old('first_name') }}"
                placeholder="Enter First Name..." required>
            <div class="text-danger">@error('first_name'){{ $message }} @enderror</div>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="last_name">Last Name <b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                value="@isset($user->last_name){{ $user->last_name }}@endisset {{ old('last_name') }}"
                placeholder="Enter Last Name..." required>
            <div class="text-danger">@error('last_name'){{ $message }} @enderror</div>
        </div>
    </div>
</div>

<div class="form-group mt-5">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" for="email">Email <b class="text-danger">*</b></label>
            <input type="email" class="form-control" name="email" id="email"
                value="@isset($user->email){{ $user->email }}@endisset" placeholder="Enter Email..." value="{{old('email')}}" required>
            <div class="text-danger">@error('email'){{ $message }} @enderror</div>
        </div>
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
    </div>
</div>

<div class="form-group mt-5">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" for="password">Password <b>*</b></label>
            <input type="password" class="form-control" name="password" id="password"  placeholder="*******"  >
            <div class="text-danger">@error('password'){{ $message }} @enderror</div>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                placeholder="********" >
            <div class="text-danger">@error('password_confirmation'){{ $message }} @enderror</div>

        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <!--begin::Login sessions-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Heading-->
            <div class="card-title">
                <h2>Location Groups</h3>
            </div>
            <!--end::Heading-->
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <div class="my-1 me-4">
                    <!--begin::Select-->
                    {{-- <select class="form-select form-select-sm form-select-solid w-125px" data-control="select2" data-placeholder="Select Hours" data-hide-search="true">
                        <option value="1" selected="selected"></option>
                        <option value="2">6 Hours</option>
                        <option value="3">12 Hours</option>
                        <option value="4">24 Hours</option>
                    </select> --}}
                    <!--end::Select-->
                </div>
                {{-- <a href="#" class="btn btn-sm btn-primary my-1">View All</a> --}}
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-0">
            <!--begin::Table wrapper-->
            {{-- <input type="text"  value={{ isset($user) ? $user->userLocationGroup[0]->user_id : '' }}> --}}
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                    <!--begin::Thead-->
                    <thead class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <tr>
                            <th class="min-w-250px">Location</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-150px">Active</th>
                            <th class="min-w-150px">Default</th>
                        </tr>
                    </thead>
                    <!--end::Thead-->
                    <!--begin::Tbody-->
                    <tbody class="fw-6 fw-bold text-gray-600">
                      <!-- checking group exist -->
                        @isset($group)
                      <!-- printing groups  -->
                            @foreach($group as $record)
                                <tr data-location_group_id="{{ isset($record->id) ? $record->id : ''}}">
                                    @php $rowCompleted=false; @endphp
                                    <td>
                                        <a href="#" class="text-hover-primary text-gray-600">{{ isset($record->name) ? $record->name :'' }}</a>
                                    </td>
                                    @isset($userLocations)
                                        @foreach($userLocations as $userLocation)
                                        @if($record->id == $userLocation->location_group_id)
                                        @php $rowCompleted=true @endphp
                                            <td class="defaultGroup">
                                                @if($userLocation->default=='1')
                                                    <span
                                                        class="badge badge-light-success fs-7 fw-bolder">default</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" class="activelocation" checked value="{{isset($userLocation->location_group_id) ? $userLocation->location_group_id : ''}}" name="activelocation[]">
                                            </td>
                                            <td>
                                                    <input type="checkbox" class="defaultlocation"
                                                    {{ $userLocation->default==1 ? "checked" :'' }}
                                                    value="{{ isset($userLocation->default) ? $userLocation->default : '' }}"
                                                    name="defaultlocation[]">
                                            </td>
                                </tr>
                                @endif
                            @endforeach
                        @endisset
                        @if($rowCompleted==false)
                        <td class="defaultGroup">
                            
                        </td>
                        <td><input type="checkbox" class="activelocation" name="activelocation[]"></td>
                        <td><input type="checkbox" class="defaultlocation" name="defaultlocation[]"></td>
                        </tr>
                        @endif
                        @endforeach
                        @endisset
                    </tbody>
                    <!--end::Tbody-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Login sessions-->
</div>
<!--end-->
@section('scripts')
@include('custom.user_js')
@endsection
