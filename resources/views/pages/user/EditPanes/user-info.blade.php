<form class="form" method="post" action="{{ route('userInformation.update',['id'=>$user->id]) }}">
    @csrf
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>User Information</h2>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="first_name">First Name <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                value="@isset($user->first_name){{ $user->first_name }}@endisset"
                                placeholder="Enter First Name..." required>
                            <div class="text-danger">@error('first_name'){{ $message }} @enderror</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="last_name">Last Name <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                value="@isset($user->last_name){{ $user->last_name }}@endisset"
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
                                value="@isset($user->email){{ $user->email }}@endisset" placeholder="Enter Email..." required>
                            <div class="text-danger">@error('email'){{ $message }} @enderror</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="type">Type </label>
                            <select class="form-control" name="type" id="type">
                                <option value="" selected disabled>Select Option</option>
                                <option value="sale" @isset($user->type) @if($user->type == 'sale') selected @endif @endisset>Sales</option>
                                <option value="production" @isset($user->type) @if($user->type == 'production') selected @endif @endisset>Production</option>
                                <option value="manager" @isset($user->type) @if($user->type == 'manager') selected @endif @endisset>Manager</option>
                            </select>
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
            </div>
        </div>
    </div>
<!-- form end inside form buttons-->
@include('pages.user.EditPanes.edit-form-buttons')


