<form class="form" method="post" id="user_location_groups_form" action="{{ route('userLocation.update',['id'=>$user->id]) }}">
    @csrf
<div class="d-flex flex-column gap-7 gap-lg-10">
  <div class="card card-flush py-4">
      <div class="card-header">
          <div class="card-title">
            <h2>Location Groups</h2>
          </div>
      </div>
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
                                      <a href="#" class="text-hover-primary text-gray-600">{{ isset($record->name) ? ucfirst($record->name) :'' }}</a>
                                  </td>
                                  @isset($userLocations)
                                      @foreach($userLocations as $userLocation)
                                      @if($record->id == $userLocation->location_group_id)
                                      @php $rowCompleted=true @endphp
                                          <td class="defaultGroup">
                                              @if($userLocation->default=='1')
                                                  <span
                                                      class="badge badge-light-success fs-7 fw-bolder">Default</span>
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
</div>
<!-- form end inside form buttons-->
@include('pages.user.EditPanes.edit-form-buttons')
