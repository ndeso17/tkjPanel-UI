<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Nama</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editForm">
                <div class="form-group">
                    <label for="currentName">Nama Sekarang</label>
                    <input type="text" class="form-control" id="currentName" name="currentName" readonly>
                </div>
                <input type="hidden" name="folderPath" value="" id="folderPath">
                <div class="form-group">
                    <label for="newName">Nama Baru</label>
                    <input type="text" class="form-control" id="newName" name="newName">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary saveRename" id="saveChanges" data-rename-fifo="">Simpan
                Perubahan</button>
        </div>
    </div>
</div>
