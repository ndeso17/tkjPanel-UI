@extends('layout/admin/app')

@section('konten')
<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>List FTP User</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Host</th>
                    <th scope="col">Username</th>
                    <th scope="col">Ciri Password</th>
                    <th scope="col">Directory Home</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($arrayFtpUser as $index => $data)
                  <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <form action="">
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $data->hostFtp }}" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $data->usernameFtp }}" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $data->cluepwFtp }}" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ str_replace('/home/tkjPanel/', '', $data->directoryFtp) }}" disabled>
                        </td>         
                        <td>
                            <a href="#" class="btn btn-danger delete-record-domain-link" data-domain-info="{{ $data->hostFtp }},{{ $data->usernameFtp }},{{ $data->cluepwFtp }},{{ $data->directoryFtp }}">
                                Hapus
                            </a>
                        </td>
                    </form>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>Add New FTP User</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body">
            <form action="" id="newRecordForm">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Host</th>
                            <th scope="col">Username</th>
                            <th scope="col">Password</th>
                            <th scope="col">Clue Password</th>
                        </tr>
                    </thead>
                   <tbody id="formNewRecord">
                        <tr>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" id="inputHost" name="inputHost">
                                <p class="combined-value " data-row-id="1" style="text-align: left; margin-left: 12%;">ftp.</p>
                            </td>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" id="inputUsername" name="inputUsername">
                            </td>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" id="inputPassword" name="inputPassword">
                            </td>                            
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" id="inputCluePassword" name="inputCluePassword">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div style="text-align: right; margin-top: 10px;">
                <a href="#" class="btn btn-success add-record-domain-link" data-domain-info="">
                    Save
                </a>
                <button type="button" class="btn btn-warning cancelAddNewRecord">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("input", function (event) {
    if (event.target.name === "inputHost") {
        const innerDomainValue = event.target.closest('tr').querySelector('input[name="inputHost"]').value;
        const childDomainValue = "ftp";
        const combinedValue = childDomainValue + '.' + innerDomainValue;

        const rowId = event.target.closest('tr').querySelector('.combined-value').getAttribute('data-row-id');
        const combinedValueParagraph = document.querySelector(`.combined-value[data-row-id="${rowId}"]`);
        combinedValueParagraph.textContent = combinedValue;
    }
    // const host = event.target.closest('tr').querySelector('input[name="inputHost"]').value;
    // const username = event.target.closest('tr').querySelector('input[name="inputUsername"]').value;
    // const password = event.target.closest('tr').querySelector('input[name="inputPassword"]').value;
    // const cluePassword = event.target.closest('tr').querySelector('input[name="inputCluePassword"]').value;
    // const rootDirectory = event.target.closest('tr').querySelector('select[name="inputDirectory"]').value;
    // console.log({hostFtp: host, usernameFtp: username, passwordFtp: password, cluePasswordFtp: cluePassword, rootDirectoryFtp: rootDirectory})
    // const dataInput = host + ',' + username + ',' + password + ',' + cluePassword + ',' + rootDirectory;
});

const cancelButton = document.querySelector(".cancelAddNewRecord");
    cancelButton.addEventListener("click", function () {
        document.getElementById("inputHost").value = "";
        document.getElementById("inputUsername").value = "";
        document.getElementById("inputPassword").value = "";
        document.getElementById("inputCluePassword").value = "";
        document.getElementById("inputDirectory").selectedIndex = 0;
        const combinedValue = "ftp.";
        const combinedValueParagraph = document.querySelector(`.combined-value`);
        combinedValueParagraph.textContent = combinedValue;
    });
</script>

<script>
    document.querySelector('.add-record-domain-link').addEventListener('click', function(event) {
        var host = document.querySelector('input[name="inputHost"]').value;
        var username = document.querySelector('input[name="inputUsername"]').value;
        var password = document.querySelector('input[name="inputPassword"]').value;
        var cluePassword = document.querySelector('input[name="inputCluePassword"]').value;
        var dataDomainInfo = host + ',' + username + ',' + password + ',' + cluePassword;
        this.setAttribute('data-domain-info', dataDomainInfo);
    });

    $(document).ready(function() {
        $('.add-record-domain-link').click(function(event) {
            event.preventDefault();

            var domainInfo = $(this).data('domain-info').split(',');
            // console.log({dataPost: domainInfo[0]})
            var hostFtp = domainInfo[0];
            var usernameFtp = domainInfo[1];
            var passwordFtp = domainInfo[2];
            var cluePasswordFtp = domainInfo[3];
            // console.log({host: hostFtp, username: usernameFtp, password: passwordFtp, cluePassword: cluePasswordFtp})

            if (confirm("Anda yakin ingin menambahkan user FTP baru?")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.addFtpClient') }}'
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
                        'name': 'host',
                        'type': 'hidden',
                        'value': hostFtp
                    }),
                    $('<input>', {
                        'name': 'username',
                        'type': 'hidden',
                        'value': usernameFtp
                    }),
                    $('<input>', {
                        'name': 'password',
                        'type': 'hidden',
                        'value': passwordFtp
                    }),
                    $('<input>', {
                        'name': 'cluePassword',
                        'type': 'hidden',
                        'value': cluePasswordFtp
                    })
                );

                $('body').append(form);
                form.submit();
            }
        });
    });
</script>
<script>
    @if(session('sukses'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('sukses') }}",
            confirmButtonText: 'Tutup'
        });
    @endif
    @if(session('gagal'))
        Swal.fire({
            icon: 'warning',
            title: 'Gagal!',
            text: "{{ session('gagal') }}",
            confirmButtonText: 'Tutup'
        });
    @endif
</script>

<script>
    $(document).ready(function() {
        $('.delete-record-domain-link').click(function(event) {
            event.preventDefault();

            var domainInfo = $(this).data('domain-info').split(',');
            var hostFtp = domainInfo[0];
            var usernameFtp = domainInfo[1];
            var cluePwFtp = domainInfo[2];
            var directoryFtp = domainInfo[3];
            console.log({host: hostFtp, username: usernameFtp, cluePassword: cluePwFtp, directory: directoryFtp})
            if (confirm("Anda yakin ingin menghapus user FTP ini?")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.deleteFtpClient') }}'
                }).append(
                    $('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': 'PUT'
                    }),
                    $('<input>', {
                        'name': '_token',
                        'type': 'hidden',
                        'value': '{{ csrf_token() }}'
                    }),
                    $('<input>', {
                        'name': 'hostFtp',
                        'type': 'hidden',
                        'value': hostFtp
                    }),
                    $('<input>', {
                        'name': 'usernameFtp',
                        'type': 'hidden',
                        'value': usernameFtp
                    }),
                    $('<input>', {
                        'name': 'cluePwFtp',
                        'type': 'hidden',
                        'value': cluePwFtp
                    }),
                    $('<input>', {
                        'name': 'directoryFtp',
                        'type': 'hidden',
                        'value': directoryFtp
                    })
                );

                $('body').append(form);
                form.submit();
            }
        });
    });
</script>
@endsection