<div class="modal-dialog">
    <div class="modal-content">
        <!-- Isi modal untuk membuat file baru -->
        <div class="modal-header">
            <h5 class="modal-title" id="createNewFileModalLabel">Create New File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="createNewFileForm" method="POST" action="{{ route('singkuasa.createNewFile') }}">
                @csrf
                <div class="form-group">
                    <label for="namaNewFile">Nama File</label>
                    <input type="text" class="form-control" id="namaNewFile" name="namaNewFile">
                </div>
                <input type="hidden" name="pathFi" value="{{ $folderPathNow }}">
                <button type="submit" class="btn btn-primary createFile" id="createNFi" data-create-fo="">
                    Create New File!
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    </div>
</div>
