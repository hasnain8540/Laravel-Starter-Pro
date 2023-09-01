<!-- Modal-->
<div class="modal fade" id="destroyModule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Confirmation</h2>
            </div>
            <form method="post" action="{{ route('module.destroy') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="module_id" id="destroyModuleId">
                    <p>Are You Sure you want to delete this Module?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-danger "> Delete</button>
                    <button type="button" class="btn  btn-light " data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
