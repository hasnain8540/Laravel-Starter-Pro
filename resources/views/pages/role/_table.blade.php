<table class="table align-middle table-row-dashed fs-6 gy-5 dataTable kt_table" >
<!--begin::Table head-->
    <thead>
    <!--begin::Table row-->
    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
        <th class="text-start fs-7 text-uppercase gs-0"> #</th>
        <th class="min-w-125px"> Name</th>
        <th class="text-end min-w-70px">Actions</th>
    </tr>
    <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-bold">
    @foreach($list as $l)
        <tr>
            <!--begin::S#-->
            <td>{{ $loop->iteration }}</td>
            <!--end::S#-->
            <!--begin::Name=-->
            <td>{{ ucfirst($l->name) }}</td>
            <!--end::Name=-->
            <!--begin::Action=-->
            <td class="text-end">
                <a href="#" class="btn btn-sm btn-light btn-primary w-125px" data-kt-menu-trigger="click"
                   data-kt-menu-placement="bottom-end"><i
                        class="fa fa-bars"></i>Actions
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="black"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon--></a>
                <!--begin::Menu-->
                <ul class="dropdown-menu" data-kt-menu="true">
                    <!--begin::Menu item-->
                    @can('edit role')
                        <li class="">
                            <a href="{{ route('role.edit',['id'=>$l->id]) }}" class="dropdown-item"><i
                                    class="fa fa-edit pe-1"></i>Edit</a>
                        </li>
                    @endcan
                <!--end::Menu item-->
                    <!--begin::Menu item-->
                    @can('view role')
                        <li class="">
                            <a href="{{ route('role.view',['id'=>$l->id]) }}" class="dropdown-item"><i
                                    class="fa fa-eye pe-1"></i>View</a>
                        </li>
                    @endcan
                <!--end::Menu item-->
                    <!--begin::Menu item-->
                    @can('delete role')
                        <li class="">
                            <a href="#" class="dropdown-item destroyRole" data-bs-toggle="modal"
                               data-bs-target="#destroyRole" data-role_id="{{ $l->id }}"
                               data-kt-customer-table-filter="delete_row"><i class="fa fa-trash pe-1"></i>Delete</a>
                        </li>
                @endcan
                <!--end::Menu item-->
                </ul>
                <!--end::Menu-->
            </td>
            <!--end::Action=-->
        </tr>
    @endforeach
    </tbody>
</table>
