<div class="modal-dialog">
    <div class="modal-content">
        <!-- Isi modal untuk mengunggah file baru -->
        <div class="modal-header">
            <h5 class="modal-title" id="upNewFileModalLabel">Upload File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="upNewFileForm" enctype="multipart/form-data" method="POST"
                action="{{ route('singkuasa.upNewFile') }}">
                @csrf
                <div class="form-group">
                    <label for="dataFile">File</label>
                    <input type="file" class="form-control" id="dataFile" name="dataFile">
                </div>
                <input type="hidden" name="pathFile" value="{{ $folderPathNow }}">
                <button type="submit" class="btn btn-primary upFile" id="upFile" data-create-fo="">
                    Upload File!
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    </div>
</div>
