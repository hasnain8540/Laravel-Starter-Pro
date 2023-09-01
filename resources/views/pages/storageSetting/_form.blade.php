<div class="row mt-6">
    <div class="col-md-12">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-20" style="min-width: 250px" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active mb-4" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Dropbox Settings</button>
                {{-- <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">S3 Bucket</button> --}}
                <button class="nav-link" id="v-pills-google-contact-api" data-bs-toggle="pill" data-bs-target="#v-pills-google-contact" type="button" role="tab" aria-controls="v-pills-google-contact-api" aria-selected="false">Google People Api</button>
            </div>
            <div class="tab-content" id="v-pills-tabContent" style="width: 100%">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="form-group">
                        <div class="row mt-5">
                            <!--begin::Col-->
                            <div class="col-xl-2">
                                <div class="fs-6 fw-bold mt-2 mb-3">Dropbox Storage</div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-xl-10">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" value="{{isset($setting['dropbox']) ? $setting['dropbox'] :''}}" type="checkbox" id="dropbox" onchange="checkdropboxBtn()" name="dropbox" />
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <label class="form-label required" for="dropbox_token">Client Id</label>
                                <input type="text" class="form-control" id="CLIENT_ID" required name="CLIENT_ID" value="{{isset($setting['CLIENT_ID'])  ? $setting['CLIENT_ID'] :''}}"  placeholder="Enter Dropbox Client Id">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <label class="form-label required" for="dropbox_token">Secret Id</label>
                                <input type="text" class="form-control" id="SECRET_ID" required name="SECRET_ID" value="{{isset($setting['SECRET_ID']) ?  $setting['SECRET_ID'] :''}}"  placeholder="Enter Dropbox Secret Id">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <label class="form-label required" for="dropbox_token">Access Code  @isset($setting['CLIENT_ID']) <span class="text-primary"><a href="https://www.dropbox.com/oauth2/authorize?client_id={{@$setting['CLIENT_ID']}}&response_type=code&token_access_type=offline" target="_blank">Generate</a></span> @endisset</label>
                                <input type="text" class="form-control" id="ACCESS_CODE" @isset($setting['CLIENT_ID']) required @endisset name="ACCESS_CODE" value="{{isset($setting['ACCESS_CODE']) ?  $setting['ACCESS_CODE']  :''}}" placeholder="Enter Dropbox Access Code">
                            </div>
                        </div>
                        {{-- <div class="row mt-5">
                            <div class="col-md-12">
                                <label class="form-label" for="dropbox_token">DropBox Token</label>
                                <input type="text" class="form-control" id="dropbox_token" name="dropbox_token" placeholder="Enter Dropbox Token">
                            </div>
                        </div> --}}
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
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="form-group">
                        <div class="row mt-5">
                            <!--begin::Col-->
                            <div class="col-xl-2">
                                <div class="fs-6 fw-bold mt-2 mb-3">S3 Bucket Storage</div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-xl-10">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="s3_bucket" onchange="checks3bucketBtn()" name="s3_bucket" />
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <label class="form-label" for="AWS_ACCESS_KEY_ID">AWS ACCESS KEY ID</label>
                                <input type="text" class="form-control" name="AWS_ACCESS_KEY_ID" id="AWS_ACCESS_KEY_ID" placeholder="Enter AWS ACCESS KEY ID">
                            </div>
                            <div class="col-md-12 mt-5">
                                <label class="form-label" for="AWS_SECRET_ACCESS_KEY">AWS SECRET ACCESS KEY</label>
                                <input type="text" class="form-control" name="AWS_SECRET_ACCESS_KEY" id="AWS_SECRET_ACCESS_KEY" placeholder="Enter AWS SECRET ACCESS KEY">
                            </div>
                            <div class="col-md-12 mt-5">
                                <label class="form-label" for="AWS_DEFAULT_REGION">AWS DEFAULT REGION</label>
                                <input type="text" class="form-control" name="AWS_DEFAULT_REGION" id="AWS_DEFAULT_REGION" placeholder="Enter AWS DEFAULT REGION">
                            </div>
                            <div class="col-md-12 mt-5">
                                <label class="form-label" for="AWS_BUCKET">AWS BUCKET</label>
                                <input type="text" class="form-control" name="AWS_BUCKET" id="AWS_BUCKET" placeholder="Enter AWS BUCKET">
                            </div>
                            <div class="col-md-12 mt-5">
                                <label class="form-label" for="AWS_USE_PATH_STYLE_ENDPOINT">AWS USE PATH STYLE ENDPOINT</label>
                                <input type="text" class="form-control" name="AWS_USE_PATH_STYLE_ENDPOINT" id="AWS_USE_PATH_STYLE_ENDPOINT" placeholder="Enter AWS USE PATH STYLE ENDPOINT">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- pane google client api --}}
                <div class="tab-pane fade" id="v-pills-google-contact" role="tabpanel" aria-labelledby="v-pills-google-contact-api">
                    <div class="form-group">
                        <label class="form-label required">  <span class="text-primary"><a href="https://console.cloud.google.com/projectcreate" target="_blank">Generate Api Credentials</a></span></label>
                       
                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <label class="form-label required" for="googleClientId">Client Id</label>
                                <input type="text" class="form-control" id="googleClientId" required name="CLIENT_ID" value="{{@$googleApi->client_id}}" placeholder="Enter Google People Client Id">
                            </div>
                            <div class="col-md-12 mt-5">
                                <label class="form-label required" for="dropbox_token">Secret Id</label>
                                <input type="text" class="form-control" id="googleSecretId" required name="SECRET_ID" value="{{@$googleApi->secret_id}}" placeholder="Enter Google People Secret Id">
                            </div>
                            <div class="col-md-12 mt-5">
                                <label class="form-label required" for="dropbox_token">Api Key</label>
                                <input type="text" class="form-control" id="googleApiKey" required name="googleApiKey" value="{{@$googleApi->googleApiKey}}"
                                       placeholder="Enter Google People Api Key">
                            </div>
                          
                           
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="card-toolbar" style="float: right">
                            <!--end::Dropdown-->
                            <!--begin::Button-->
                                <button class="btn btn-sm btn-primary font-weight-bold mb-5" id="addGoogleAccount">
                                Save Changes
                                </button>
                            <!--end::Button-->
                        </div>
                    </div>
                </div>
                {{-- pane google client api --}}

            </div>
        </div>
    </div>
</div>

