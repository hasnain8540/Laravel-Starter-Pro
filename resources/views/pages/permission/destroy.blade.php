<!-- Modal-->
<div class="modal fade" id="destroyPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Confirmation</h2>
            </div>
            <form method="post" action="{{ route('permission.destroy') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="permission_id" id="PermissionId">
                    <p>Are You Sure you want to delete this Permission?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-danger "> Delete</button>
                    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
    </div>
</div>
