<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>File Manager | tkjPanel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/filemanager.css') }}" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="{{ route('singkuasa.index') }}">tkjPanel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    {{-- <a class="btn btn-danger" href="{{ route('singkuasa.fileManager') }}" id="buangCode">
                        Cancel
                        <i class='bx bx-arrow-back'></i>
                        <span class="sr-only">(current)</span>
                    </a> --}}
                    <a class="btn btn-danger" href="#" id="buangCode">
                        Cancel
                        <i class='bx bx-arrow-back'></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item active" style="margin-left: 10px;">
                    <a class="btn btn-success" href="#" id="simpanCode">
                        Save
                        <i class="lni lni-cloud-upload"></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="editor-container">
        <input type="hidden" name="fileName" value="{{ $fileName }}">
        <div id="editor">
            {{ $content }}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5.9.2/tinymce.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.5.3/ace.js"></script>
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
        document.getElementById("buangCode").addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah perilaku default dari link

            window.close(); // Menutup tab saat ini
            window.history.back(); // Kembali ke tab sebelumnya
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/cobalt");
            if (`{{ $ekstensi }}` === "js") {
                editor.session.setMode("ace/mode/javascript");
            } else if (`{{ $ekstensi }}` === "html") {
                editor.session.setMode("ace/mode/html");
            } else if (`{{ $ekstensi }}` === "xml") {
                editor.session.setMode("ace/mode/xml");
            } else if (`{{ $ekstensi }}` === "css") {
                editor.session.setMode("ace/mode/css");
            } else if (`{{ $ekstensi }}` === "php") {
                editor.session.setMode("ace/mode/php");
            } else if (`{{ $ekstensi }}` === "sql") {
                editor.session.setMode("ace/mode/sql");
            } else if (`{{ $ekstensi }}` === "json") {
                editor.session.setMode("ace/mode/json");
            } else if (`{{ $ekstensi }}` === "sh" || `{{ $ekstensi }}` === "bash") {
                editor.session.setMode("ace/mode/sh");
            } else {
                editor.session.setMode("ace/mode/text");
                // Python (ace/mode/python)
                // Java (ace/mode/java)
                // Ruby (ace/mode/ruby)
                // C/C++ (ace/mode/c_cpp)
                // C# (ace/mode/csharp)
                // Swift (ace/mode/swift)
                // Go (ace/mode/golang)
                // TypeScript (ace/mode/typescript)
                // Markdown (ace/mode/markdown)
                // YAML (ace/mode/yaml)
                // Perl (ace/mode/perl)
                // Rust (ace/mode/rust)
                // Kotlin (ace/mode/kotlin)
                // Scala (ace/mode/scala)
                // Dockerfile (ace/mode/dockerfile)
                // PowerShell (ace/mode/powershell)
                // Visual Basic (ace/mode/vbscript) 
            }

            function getValueFromEditor() {
                return editor.getValue();
            }

            function postData(fileName, contentValue) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('singkuasa.saveFileEditor') }}";
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken;

                const namaFileInput = document.createElement("input");
                namaFileInput.type = "hidden";
                namaFileInput.name = "namaFile";
                namaFileInput.value = fileName;

                const contentInput = document.createElement("input");
                contentInput.type = "hidden";
                contentInput.name = "content";
                contentInput.value = contentValue;

                form.appendChild(csrfInput);
                form.appendChild(namaFileInput);
                form.appendChild(contentInput);

                form.style.display = "none";
                document.body.appendChild(form);
                form.submit();
            }
            document
                .getElementById("simpanCode")
                .addEventListener("click", function() {
                    var contentValue = getValueFromEditor();
                    var fileName = document.querySelector(
                        'input[name="fileName"]'
                    ).value;
                    console.log({
                        namaFile: fileName,
                        isiCode: contentValue
                    });
                    postData(fileName, contentValue)
                });
        });
    </script>
</body>
