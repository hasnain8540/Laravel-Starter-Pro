<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-label" for="name">Name <b class="text-danger">*</b></label>
            <input type="text" class="form-control" name="name" id="name" value="@isset($detail->name) {{$detail->name}} @endisset" required placeholder="Enter Module Name...">
        </div>
    </div>
</div>
