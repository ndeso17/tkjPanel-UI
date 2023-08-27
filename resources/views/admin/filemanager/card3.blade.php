<div class="card">
    <div class="card-body">
        @include('admin.filemanager.card3.bar.search')
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Size</th>
                        <th>Izin</th>
                        <th>Last Edit</th>
                        <th>Owner/Grup</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="folderContents">
                    @if ($selectedFolder)
                        @foreach ($folderContents as $item)
                            @include('admin.filemanager.card3.tabel.tr1.tr')
                        @endforeach
                    @elseif ($selectedSubFolder || $folderPathSesion)
                        @foreach ($subFolderContents as $item)
                            @include('admin.filemanager.card3.tabel.tr2.tr')
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
