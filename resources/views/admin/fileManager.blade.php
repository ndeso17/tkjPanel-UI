<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>File Manager | tkjPanel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    {{-- <script src="https://kit.fontawesome.com/2eee75b418.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="{{ asset('filemanager/style.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">tkjPanel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        New Folder
                        <i class="lni lni-plus"></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        Up New File
                        <i class="lni lni-cloud-upload"></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid" style="margin-top: 10px">
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid">
                            <a href="{{ route('singkuasa.index') }}" class="btn btn-primary">
                                <i class="lni lni-reply"></i>
                                Back To tkjPanel
                            </a>
                        </div>
                        <h5 class="my-3">Root Folder</h5>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                {{-- @php
                                    dd($directoryContents);
                                @endphp --}}
                                @foreach ($directoryContents as $item)
                                    <a href="#" class="list-group-item py-1 folder-link"
                                        data-folder="{{ $item }}">
                                        <i class="bx bx-folder me-2"></i>
                                        <span>{{ $item }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="mt-1">
                            <span class="text-secondary">Storage</span>
                            <span class="float-end text-primary">Information</span>
                        </p>
                        <h5 class="mb-0 text-primary font-weight-bold">
                            {{ $usedSpace }}
                            <span class="float-end text-secondary">of {{ $freeSpace }}</span>
                        </h5>
                        <div class="progress mt-3" style="height:7px;">
                            @foreach ($dataSizeFile as $key => $size)
                                @php
                                    // dd($size);
                                    $progressColor = 'bg-white';
                                    switch ($key) {
                                        case 'unformat':
                                            $progressColor = 'bg-unformat';
                                            break;
                                        case 'video':
                                            $progressColor = 'bg-video';
                                            break;
                                        case 'image':
                                            $progressColor = 'bg-image';
                                            break;
                                        case 'sql':
                                            $progressColor = 'bg-sql';
                                            break;
                                        case 'js':
                                            $progressColor = 'bg-js';
                                            break;
                                        case 'css':
                                            $progressColor = 'bg-css';
                                            break;
                                        case 'html':
                                            $progressColor = 'bg-html';
                                            break;
                                        case 'php':
                                            $progressColor = 'bg-php';
                                            break;
                                    }
                                @endphp
                                <div class="progress-bar {{ $progressColor }}" role="progressbar"
                                    style="width: {{ ($size / array_sum($dataSizeFile)) * 100 }}%"
                                    aria-valuenow="{{ ($size / array_sum($dataSizeFile)) * 100 }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3"></div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-danger">
                                <i class="lni lni-php"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Php</h6>
                                <p class="mb-0 text-secondary">{{ $phpFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalPhpFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-success">
                                <i class='bx bxl-html5'></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Html</h6>
                                <p class="mb-0 text-secondary">{{ $htmlFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalHtmlFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-primary">
                                <i class='bx bxl-css3'></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Css</h6>
                                <p class="mb-0 text-secondary">{{ $cssFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalCssFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-warning">
                                <i class='bx bxs-file-js'></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Js</h6>
                                <p class="mb-0 text-secondary">{{ $jsFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalJsFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-light">
                                <svg fill="#1C2033" width="52" height="52" viewBox="0 0 64 64"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_412_93)">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M58.9525 49.8529C55.4717 49.7559 52.7713 50.1127 50.508 51.0648C49.8563 51.3265 48.8105 51.3265 48.7246 52.1467C49.0729 52.4909 49.1148 53.0542 49.4202 53.5312C49.9421 54.397 50.8572 55.5634 51.6835 56.1683L54.4688 58.1588C56.1663 59.1962 58.0813 59.8021 59.7349 60.8405C60.6929 61.4464 61.65 62.225 62.608 62.8745C63.0958 63.2207 63.3914 63.784 64.0011 63.9992V63.8683C63.6967 63.4805 63.6089 62.9182 63.3055 62.4838L61.9982 61.2302C60.7368 59.5433 59.1691 58.0715 57.4716 56.8615C56.0785 55.9095 53.0327 54.6122 52.4669 53.0125L52.381 52.9156C53.3371 52.8186 54.4688 52.4822 55.3839 52.2224C56.8648 51.8346 58.213 51.9199 59.7349 51.5311L61.8256 50.9251V50.5373C61.0422 49.7588 60.4764 48.7204 59.65 47.9855C57.4306 46.0824 54.9917 44.2219 52.4669 42.6648C51.1177 41.8 49.3763 41.2367 47.9402 40.5027C47.4164 40.2429 46.5471 40.113 46.2428 39.6806C45.4574 38.7305 45.0233 37.4749 44.4575 36.3493L40.8888 28.8229C40.1054 27.1359 39.6254 25.4489 38.6694 23.8919C34.1857 16.538 29.3097 12.0831 21.8232 7.71342C20.2135 6.80497 18.2985 6.41425 16.2624 5.93919L12.9982 5.76467C12.3006 5.46218 11.605 4.64002 10.9953 4.25027C8.51441 2.69322 2.11564 -0.680726 0.286436 3.76551C-0.889129 6.57713 2.02783 9.34513 3.01804 10.7732C3.75947 11.768 4.71553 12.8926 5.23942 14.0173C5.53209 14.7522 5.62965 15.5317 5.935 16.3102C6.63059 18.2134 7.28422 20.3337 8.19833 22.108C8.68612 23.0164 9.1983 23.9694 9.80803 24.7906C10.1563 25.2754 10.7661 25.4829 10.8958 26.2614C10.2861 27.1272 10.2441 28.4234 9.89583 29.5064C8.32808 34.3947 8.93781 40.4504 11.1573 44.0493C11.8548 45.1303 13.4986 47.5105 15.7288 46.6011C17.6877 45.8225 17.2507 43.357 17.8165 41.194C17.9482 40.6753 17.8604 40.3292 18.1209 39.9821V40.0791L19.9062 43.6692C21.2554 45.7886 23.6065 47.9952 25.5645 49.467C26.6084 50.2455 27.4357 51.5873 28.741 52.0624V51.9315H28.6551C28.3937 51.5437 28.0015 51.3692 27.6532 51.0667C26.8698 50.2882 25.9996 49.3361 25.3899 48.4713C23.5626 46.0494 21.9529 43.3667 20.5159 40.5987C19.8184 39.2579 19.2087 37.7871 18.6448 36.4463C18.3814 35.9266 18.3814 35.1471 17.9473 34.8892C17.2936 35.8393 16.3376 36.6634 15.8566 37.8307C15.0293 39.6903 14.9435 41.9832 14.6391 44.3624C14.4635 44.4061 14.5415 44.3624 14.4635 44.4594C13.0723 44.1142 12.5923 42.6852 12.0704 41.4752C10.7651 38.4037 10.5465 33.4727 11.6782 29.9252C11.9826 29.0168 13.2899 26.1615 12.7679 25.2967C12.5045 24.4746 11.6363 23.9995 11.1563 23.3499C10.5904 22.5278 9.98265 21.4904 9.59047 20.5819C8.54661 18.1581 8.02468 15.4774 6.89204 13.0545C6.36815 11.9299 5.45502 10.7616 4.71456 9.72421C3.88728 8.55593 2.97512 7.73378 2.32148 6.35026C2.10393 5.8655 1.79955 5.0957 2.14783 4.57604C2.23368 4.22991 2.40928 4.09127 2.75561 4.01371C3.32144 3.52895 4.93309 4.14363 5.49892 4.40152C7.10861 5.0511 8.45783 5.65609 9.80705 6.56356C10.4168 6.99597 11.0704 7.81813 11.8538 8.0353H12.7689C14.162 8.33779 15.7278 8.13225 17.0322 8.52006C19.3394 9.2569 21.4281 10.337 23.3012 11.5062C29.0024 15.0963 33.7047 20.2009 36.8812 26.3012C37.4031 27.2959 37.6206 28.2043 38.1006 29.2427C39.0157 31.363 40.1474 33.5251 41.0595 35.6028C41.9746 37.6359 42.8448 39.7136 44.1501 41.4005C44.8038 42.309 47.4144 42.784 48.589 43.2601C49.4602 43.6479 50.8084 43.9969 51.5938 44.472C53.0727 45.3804 54.5527 46.4188 55.9448 47.4135C56.6404 47.9313 58.8179 49.0132 58.9476 49.8761L58.9525 49.8529ZM14.564 12.2624C13.9626 12.2571 13.3631 12.3298 12.7806 12.4786V12.5756H12.8665C13.2147 13.2678 13.8245 13.7439 14.2596 14.3498L15.2615 16.4265L15.3473 16.3296C15.9571 15.8972 16.2624 15.2049 16.2624 14.1675C16.001 13.8651 15.9581 13.5616 15.7405 13.2591C15.479 12.8267 14.9132 12.6095 14.564 12.2644V12.2624Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_412_93">
                                            <rect width="64" height="64" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Sql</h6>
                                <p class="mb-0 text-secondary">{{ $sqlFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalSqlFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-secondary">
                                <i class='bx bxs-file-image'></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Image</h6>
                                <p class="mb-0 text-secondary">{{ $imageFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalImageFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary text-black">
                                <i class='bx bxs-video'></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Video</h6>
                                <p class="mb-0 text-secondary">{{ $videoFileCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $totalVideoFileSize }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="fm-file-box bg-light-primary" style="color: brown;">
                                <i class='bx bxs-file-blank'></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Unformat</h6>
                                <p class="mb-0 text-secondary">{{ $unformatFilesCount }} Files</p>
                            </div>
                            <h6 class="text-primary mb-0">
                                {{ $unformatFilesSize }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="fm-search">
                            <div class="mb-0">
                                <div class="input-group input-group-lg"> <span
                                        class="input-group-text bg-transparent"><i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Search the files">
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 10px" class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0">Files</h5>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Size</th>
                                        <th>Izin</th>
                                        <th>Tanggal Upload/Edit</th>
                                        <th>Owner/Grup</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="folderContents">
                                    @if ($selectedFolder)
                                        @php
                                            dd($folderContents);
                                        @endphp
                                        @foreach ($folderContents as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($item['extension'] == 'php')
                                                            <div>
                                                                <i class='bx bxl-php me-2 font-24 text-danger'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-danger">
                                                                {{ $item['name'] }}
                                                            </div>
                                                        @elseif ($item['extension'] == 'js')
                                                            <div>
                                                                <i
                                                                    class='bx bxl-file-js me-2 font-24 text-warning'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-warning">
                                                                {{ $item['name'] }}
                                                            </div>
                                                        @elseif ($item['extension'] == 'json')
                                                            <div>
                                                                <i
                                                                    class='bx bxl-file-json me-2 font-24 text-warning'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-warning">
                                                                {{ $item['name'] }}
                                                            </div>
                                                        @elseif ($item['extension'] == 'html')
                                                            <div>
                                                                <i
                                                                    class='bx bxl-file-json me-2 font-24 text-success'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-succsess">
                                                                {{ $item['name'] }}
                                                            </div>
                                                        @elseif ($item['extension'] == 'css')
                                                            <div>
                                                                <i class='bx bxl-file-json me-2 font-24 text-info'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-info">
                                                                {{ $item['name'] }}
                                                            </div>
                                                        @else
                                                            <div>
                                                                <i
                                                                    class='bx bxs-folder me-2 font-24 text-secondary'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-secondary">
                                                                {{ $item['name'] }}
                                                            </div>
                                                            {{-- @if ($item['size'] == 'Folder')
                                                                <a
                                                                    href="{{ route('singkuasa.fileManager', ['folderPath' => $item['name']]) }}">
                                                                    <div>
                                                                        <i
                                                                            class='bx bxs-folder me-2 font-24 text-secondary'></i>
                                                                    </div>
                                                                    <div class="font-weight-bold text-secondary">
                                                                        {{ $item['name'] }}
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <div>
                                                                    <i
                                                                        class='bx bxs-folder me-2 font-24 text-secondary'></i>
                                                                </div>
                                                                <div class="font-weight-bold text-secondary">
                                                                    {{ $item['name'] }}
                                                                </div>
                                                            @endif --}}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $item['size'] }}</td>
                                                <td>{{ $item['permission'] }}</td>
                                                <td>{{ $item['created_at'] }} | {{ $item['updated_at'] }}</td>
                                                <td title="{{ implode(', ', $item['owner']) }}">{{ $item['grup'] }}
                                                </td>
                                                <td>
                                                    @if ($item['size'] == 'Folder')
                                                        <a class="me-2 font-24"
                                                            style="text-decoration: none; color: black;"
                                                            href="#" title="Edit {{ $item['name'] }}">
                                                            <i class='bx bx-edit-alt'></i>
                                                        </a>
                                                        <a class="me-2 font-24"
                                                            style="text-decoration: none; color: black;"
                                                            href="#" title="Delete {{ $item['name'] }}">
                                                            <i class='bx bxs-trash'></i>
                                                        </a>
                                                    @else
                                                        <a class="me-2 font-24"
                                                            style="text-decoration: none; color: black;"
                                                            href="#" title="Edit {{ $item['name'] }}">
                                                            <i class='bx bx-edit-alt'></i>
                                                        </a>
                                                        <a class="me-2 font-24"
                                                            style="text-decoration: none; color: black;"
                                                            href="#" title="Copy {{ $item['name'] }}">
                                                            <i class='bx bx-copy-alt'></i>
                                                        </a>
                                                        <a class="me-2 font-24"
                                                            style="text-decoration: none; color: black;"
                                                            href="#" title="Download {{ $item['name'] }}">
                                                            <i class='bx bx-cloud-download'></i>
                                                        </a>
                                                        <a class="me-2 font-24"
                                                            style="text-decoration: none; color: black;"
                                                            href="#" title="Delete {{ $item['name'] }}">
                                                            <i class='bx bxs-trash'></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
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

</body>

</html>
