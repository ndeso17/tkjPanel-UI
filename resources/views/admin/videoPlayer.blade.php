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
    <link rel="stylesheet" href="{{ asset('custom/filemanagerVideoPlayer.css') }}" />
    <link href="https://vjs.zencdn.net/8.5.2/video-js.css" rel="stylesheet" />
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
                    <a class="btn btn-danger" href="#" id="buangCode">
                        Kembali
                        <i class='bx bx-arrow-back'></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item active" style="margin-left: 10px;">
                    <a class="btn btn-success" href="#" id="simpanCode">
                        Download Video
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
            <video id="my-video" class="video-js" controls preload="auto" width="992" height="552"
                data-setup="{}">
                <source src="{{ $link }}" type="video/mp4" />
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.5.3/ace.js"></script>
    <script src="https://vjs.zencdn.net/8.5.2/video.min.js"></script>

    <script>
        document.getElementById("buangCode").addEventListener("click", function(event) {
            event.preventDefault();

            window.close();
            window.history.back();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function getValueFromEditor() {
                return editor.getValue();
            }

            function postData(fileName, contentValue) {
                const form = document.createElement("form");
                form.method = "POST";
                form.target = "_blank";
                form.action = "{{ route('singkuasa.saveVideo') }}";
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

                form.appendChild(csrfInput);
                form.appendChild(namaFileInput);

                form.style.display = "none";
                document.body.appendChild(form);
                form.submit();
            }
            document
                .getElementById("simpanCode")
                .addEventListener("click", function() {
                    var fileName = document.querySelector(
                        'input[name="fileName"]'
                    ).value;
                    console.log({
                        namaFile: fileName
                    });
                    postData(fileName)
                });
        });
    </script>
</body>
