<div class="modal-dialog">
    <div class="modal-content">
        <!-- Isi modal untuk membuat folder -->
        <div class="modal-header">
            <h5 class="modal-title" id="createNewFolderModalLabel">Create New Folder</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="createNewFolderForm" method="POST" action="{{ route('singkuasa.createNewFolder') }}">
                @csrf
                <div class="form-group">
                    <label for="namaNewFolder">Nama Folder</label>
                    <input type="text" class="form-control" id="namaNewFolder" name="namaNewFolder">
                </div>
                <input type="hidden" name="pathFo" value="{{ $folderPathNow }}" id="pathFo">
                <button type="submit" class="btn btn-primary createFolder" id="createNFo" data-create-fo="">
                    Create New Folder!
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    </div>
</div>
