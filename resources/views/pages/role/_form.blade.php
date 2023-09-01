<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-label" for="name">Name <b class="text-danger">*</b></label>
            <input type="text" class="form-control" name="name" id="name" value="@isset($role->name) {{ $role->name }} @endisset" placeholder="Enter Role Name..." required>
        </div>
    </div>
</div>

<div class="clearfix mt-10"></div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td><center><h3>Permissions</h3></center></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-striped table-row-dashed">
            <thead>
                <th><b>Module</b></th>
                <th><b>Show</b></th>
                <th><b>Create</b></th>
                <th><b>Edit</b></th>
                <th><b>View</b></th>
                <th><b>Delete</b></th>
                <th><b>Other</b></th>
            </thead>
            <tbody>
                @foreach($module as $m)
                    @php
                        $show = '';
                        $create = '';
                        $edit = '';
                        $view = '';
                        $delete = '';
                        $other = '';
                    @endphp
                    @foreach($m->permission as $mp)
                        @if($mp->type == 'show')
                            @php
                                if(isset($role)) {
                                    if($role->hasPermissionTo($mp)) {
                                        $show .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" checked> &nbsp;'.$mp->name.'</label></fieldset>';
                                    } else {
                                        $show .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                    }
                                } else {
                                    $show .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                }
                            @endphp
                        @elseif($mp->type == 'create')
                            @php
                                if(isset($role)) {
                                    if($role->hasPermissionTo($mp)) {
                                        $create .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" checked> &nbsp;'.$mp->name.'</label></fieldset>';
                                    } else {
                                        $create .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                    }
                                } else {
                                    $create .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                }
                            @endphp
                        @elseif($mp->type == 'edit')
                            @php
                                if(isset($role)) {
                                    if($role->hasPermissionTo($mp)) {
                                        $edit .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" checked> &nbsp;'.$mp->name.'</label></fieldset>';
                                    } else {
                                        $edit .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                    }
                                } else {
                                    $edit .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                }
                            @endphp
                        @elseif($mp->type == 'view')
                            @php
                                if(isset($role)) {
                                    if($role->hasPermissionTo($mp)) {
                                        $view .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" checked> &nbsp;'.$mp->name.'</label></fieldset>';
                                    } else {
                                        $view .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                    }
                                } else {
                                    $view .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                }
                            @endphp
                        @elseif($mp->type == 'delete')
                            @php
                                if(isset($role)) {
                                    if($role->hasPermissionTo($mp)) {
                                        $delete .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" checked> &nbsp;'.$mp->name.'</label></fieldset>';
                                    } else {
                                        $delete .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                    }
                                } else {
                                    $delete .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                }
                            @endphp
                        @elseif($mp->type == 'other')
                            @php
                                if(isset($role)) {
                                    if($role->hasPermissionTo($mp)) {
                                        $other .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" checked> &nbsp;'.$mp->name.'</label></fieldset>';
                                    } else {
                                        $other .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                    }
                                } else {
                                    $other .= '<fieldset class="checkboxsas"><label style="color: black"><input type="checkbox" name="permission[]" value="'.$mp->id.'" > &nbsp;'.$mp->name.'</label></fieldset>';
                                }
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td><b >{{ ucwords($m->name) }}</b></td>
                        <td>{!! $show !!}</td>
                        <td>{!! $create !!}</td>
                        <td>{!! $edit !!}</td>
                        <td>{!! $view !!}</td>
                        <td>{!! $delete !!}</td>
                        <td>{!! $other !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
