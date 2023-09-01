<!-- Modal-->
<div class="modal fade" id="detachRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Confirmation</h2>
            </div>
            <form method="post" action="{{ route('userRole.detach') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="detachUserId">
                    <input type="hidden" name="role_id" id="detachRoleId">
                    <p>Are You Sure you want to Detach this Role?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-danger "> Detach</button>
                    <button type="button" class="btn  btn-light " data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

