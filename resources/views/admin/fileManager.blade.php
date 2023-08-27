<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.filemanager.header')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        @include('admin.filemanager.navbar')
    </nav>
    <div class="container-fluid" style="margin-top: 10px">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('admin.filemanager.card1')
                @include('admin.filemanager.card2')
            </div>
            <div class="col-12 col-lg-9">
                @include('admin.filemanager.card3')
            </div>
        </div>
    </div>
    {{-- Modul --}}
    <!-- Modal New Folder -->
    <div class="modal" id="newFolderModal">
        @include('admin.filemanager.modalNewFolder')
    </div>
    <!-- Modal New File -->
    <div class="modal" id="newFileModal">
        @include('admin.filemanager.modalNewFile')
    </div>

    <!-- Modal Up New File -->
    <div class="modal" id="upNewFileModal">
        @include('admin.filemanager.modalUpNewFile')
    </div>
    <!-- Modal Rename FiFo -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        @include('admin.filemanager.modalRenameFiFo')
    </div>
    <script>
        document.querySelector('.saveRename').addEventListener('click', function(event) {
            var namaLama = document.querySelector('input[name="currentName"]').value;
            var folderPath = document.querySelector('input[name="folderPath"]').value;
            var namaBaru = document.querySelector('input[name="newName"]').value;
            var dataRename = namaLama + ',' + namaBaru + ',' + folderPath;
            this.setAttribute('data-rename-fifo', dataRename);
        });
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".saveRename");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();

                    const originalName = this.getAttribute("data-rename-fifo");
                    const dataSplit = originalName.split(',');
                    console.log(dataSplit);
                    const namaLama = dataSplit[0]
                    const namaBaru = dataSplit[1]
                    const folderPath = dataSplit[2]

                    if (confirm("Anda yakin dengan yang anda lakukan?")) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route('singkuasa.renameFiFo') }}'
                        }).append(
                            $('<input>', {
                                'name': '_method',
                                'type': 'hidden',
                                'value': 'POST'
                            }),
                            $('<input>', {
                                'name': '_token',
                                'type': 'hidden',
                                'value': '{{ csrf_token() }}'
                            }),
                            $('<input>', {
                                'name': 'namaBaru',
                                'type': 'hidden',
                                'value': namaBaru
                            }),
                            $('<input>', {
                                'name': 'namaLama',
                                'type': 'hidden',
                                'value': namaLama
                            }),
                            $('<input>', {
                                'name': 'folderPath',
                                'type': 'hidden',
                                'value': folderPath
                            })
                        );

                        $('body').append(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".renameFiFo");
            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();

                    const originalName = this.getAttribute("data-original-name");
                    const folderPath = this.getAttribute("data-name");
                    if (originalName !== "public_html" && originalName !== "public_ftp") {
                        const currentNameInput = document.getElementById("currentName");
                        const folderPathInput = document.getElementById("folderPath");
                        currentNameInput.value = originalName;
                        folderPathInput.value = folderPath;
                        $('#editModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error!',
                            text: 'Maaf, kamu tidak dapat mengedit file atau folder pada directory root. Silahkan gunakan terminal dengan akses root.'
                        });
                    }

                });
            });

        });
    </script>


    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript"></script>
    @if (isset($successMessage))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ $successMessage }}'
            });
        </script>
    @elseif (isset($errorMessage))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Gagal!',
                text: '{{ $errorMessage }}'
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".folder-link");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault(); // Menghentikan perilaku bawaan tautan

                    const folderName = this.getAttribute("data-folder");
                    sendPostRequest(folderName);
                });
            });

            function sendPostRequest(folderName) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('singkuasa.fileManager') }}"; // Ubah sesuai rute yang benar

                // Tambahkan token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "folder";
                input.value = folderName;

                form.appendChild(csrfInput);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".subFolder-link");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault(); // Menghentikan perilaku bawaan tautan

                    const folderName = this.getAttribute("data-subFolder");
                    sendPostRequest(folderName);
                });
            });

            function sendPostRequest(folderName) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('singkuasa.fileManager') }}"; // Ubah sesuai rute yang benar

                // Tambahkan token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "subfolder";
                input.value = folderName;

                form.appendChild(csrfInput);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".linkDownload");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();

                    const fileDownloads = this.getAttribute("data-fileDownload");
                    sendPostRequest(fileDownloads);
                });
            });

            function sendPostRequest(fileDownloads) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('singkuasa.downloadFile') }}";

                // Tambahkan token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "fileDownloads";
                input.value = fileDownloads;

                form.appendChild(csrfInput);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>

    <script>
        const fileSearchInput = document.getElementById('fileSearchInput');
        const folderContents = document.getElementById('folderContents');

        fileSearchInput.addEventListener('input', function() {
            const searchQuery = fileSearchInput.value.trim().toLowerCase();

            for (const row of folderContents.rows) {
                const fileName = row.cells[0].textContent.toLowerCase();
                if (fileName.includes(searchQuery)) {
                    row.style.display = ''; // Tampilkan baris yang cocok
                } else {
                    row.style.display = 'none'; // Sembunyikan baris yang tidak cocok
                }
            }
        });
    </script>
    @if (session('sukses'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "{{ session('sukses') == 'sukses' ? 'success' : 'error' }}",
                    title: "{{ session('sukses') == 'sukses' ? 'Sukses' : 'Gagal' }}",
                    text: "{{ session('message') }}",
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".classDeleteFiFo");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();

                    const targetFiFo = this.getAttribute("target-delete");
                    if (confirm("Anda yakin dengan yang anda lakukan?")) {
                        requestDelete(targetFiFo)

                    }
                });
            });

            function requestDelete(targetFiFo) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('singkuasa.deleteFiFo') }}";
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "targetFiFo";
                input.value = targetFiFo;

                form.appendChild(csrfInput);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".editFile");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();

                    const filePath = this.getAttribute("target-edit");
                    requestDelete(filePath)
                });
            });

            function requestDelete(filePath) {
                const form = document.createElement("form");
                form.method = "GET";
                form.target = "_blank";
                form.action = "{{ route('singkuasa.fileEditor') }}";
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "filePath";
                input.value = filePath;

                form.appendChild(csrfInput);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folderLinks = document.querySelectorAll(".playVideo");

            folderLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();

                    const filePath = this.getAttribute("target-play");
                    requestDelete(filePath)
                });
            });

            function requestDelete(filePath) {
                const form = document.createElement("form");
                form.method = "POST";
                form.target = "_blank";
                form.action = "{{ route('singkuasa.playVideo') }}";
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "filePath";
                input.value = filePath;

                form.appendChild(csrfInput);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>

</body>

</html>
