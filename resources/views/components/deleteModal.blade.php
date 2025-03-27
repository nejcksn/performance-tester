<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <span id="type"></span> <strong id="name"></strong>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#deleteModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let type = button.data('type');
            let id = button.data('id');
            let name = button.data('name');
            let route = button.data('route');

            let modal = $(this);
            modal.find('#name').text(name);
            modal.find('#type').text(type);
            modal.find('#deleteForm').attr('action', route + '/' + id);
        });
    });
</script>
@endpush
