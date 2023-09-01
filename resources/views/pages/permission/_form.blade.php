<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" for="module">Module <b class="text-danger">*</b></label>
            <select class="form-control" id="module" aria-label="{{ __('Select Option') }}" data-control="select2" data-placeholder="{{ __('Select Option...') }}" name="module" required>
                <option value="" selected disabled>{{ __('Select Option') }}</option>
                @foreach($module as $m)
                    <option value="{{ $m->id }}" @isset($detail->module_id) @if($detail->module_id == $m->id) selected @endif @endisset>{{ ucwords($m->name) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="type">Type <b class="text-danger">*</b></label>
            <select class="form-control" id="type" name="type" aria-label="{{ __('Select Type') }}" data-control="select2" data-placeholder="{{ __('Select Type...') }}"  required>
                <option value="" selected disabled>{{ __('Select Type') }}</option>
                <option value="show" @isset($detail->type) @if($detail->type == 'show') selected @endif @endisset>Show</option>
                <option value="create" @isset($detail->type) @if($detail->type == 'create') selected @endif @endisset>Create</option>
                <option value="edit" @isset($detail->type) @if($detail->type == 'edit') selected @endif @endisset>Edit</option>
                <option value="view" @isset($detail->type) @if($detail->type == 'view') selected @endif @endisset>View</option>
                <option value="delete" @isset($detail->type) @if($detail->type == 'delete') selected @endif @endisset>Delete</option>
                <option value="other" @isset($detail->type) @if($detail->type == 'other') selected @endif @endisset>Other</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group mt-5">
    <div class="row">
        <div class="col-md-12">
            <label class="form-label" for="name">Name <b class="text-danger">*</b></label>
            <input type="text" class="form-control" name="name" id="name" value="@isset($detail->name) {{ $detail->name }} @endisset" placeholder="Enter Permission Name..." required>
        </div>
    </div>
</div>
