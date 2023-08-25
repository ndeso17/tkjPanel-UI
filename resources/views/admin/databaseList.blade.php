@extends('layout/admin/app')

@section('konten')
<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>List Database</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Database</th>
                    <th scope="col">Owner Database</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                @foreach ($database as $datas) 
                  <tr>
                    <th scope="row">{{ $no++ }}</th>
                    <form action="">
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $datas->databaseName }}" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $datas->userOwner }}" disabled>
                        </td>       
                        <td>
                            <a href="#" class="btn btn-danger delete-record-domain-link" data-domain-info="">
                                Hapus
                            </a>
                            {{-- <a href="#" class="btn btn-danger delete-record-domain-link" data-domain-info="{{ $data->hostFtp }},{{ $data->usernameFtp }},{{ $data->cluepwFtp }},{{ $data->directoryFtp }}">
                                Hapus
                            </a> --}}
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
        <h5>Add New Database</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body">
            <form action="" id="newDatabase">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Owner Name</th>
                            <th scope="col">Database Name</th>
                        </tr>
                    </thead>
                   <tbody id="formNewDatabase">
                        <tr>
                            <td>
                                <select style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" name="inputOwnerName" id="inputOwnerName">
                                    <option value="" selected>---Null---</option>
                                    @foreach ($dataOwner as $owner)
                                        <option value="{{ $owner->userOwner }}">{{ $owner->userOwner }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" id="inputDatabaseName" name="inputDatabaseName">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div style="text-align: right; margin-top: 10px;">
                <a href="#" class="btn btn-success add-database-link" data-new-database="">
                    Save
                </a>
                <button type="button" class="btn btn-warning cacelAddDatabase">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>List User Database</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">User</th>
                    <th scope="col">Ciri Password</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataOwner as $data)    
                    <tr>
                      <th scope="row">{{ $no++ }}</th>
                      <form action="">
                          <td>
                              <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $data->userOwner }}" disabled>
                          </td>
                          <td>
                              <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $data->kunciCiri }}" disabled>
                          </td>       
                          <td>
                              <a href="#" class="btn btn-danger delete-record-domain-link" data-domain-info="">
                                  Hapus
                              </a>
                              {{-- <a href="#" class="btn btn-danger delete-record-domain-link" data-domain-info="{{ $data->hostFtp }},{{ $data->usernameFtp }},{{ $data->cluepwFtp }},{{ $data->directoryFtp }}">
                                  Hapus
                              </a> --}}
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
        <h5>Add New User Database</h5>
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
const cancelButton = document.querySelector(".cancelAddNewRecord");
    cancelButton.addEventListener("click", function () {
        document.getElementById("inputHost").value = "";
        document.getElementById("inputUsername").value = "";
        document.getElementById("inputPassword").value = "";
        document.getElementById("inputCluePassword").value = "";
        window.location.reload();
    });
const tombolCancel = document.querySelector(".cacelAddDatabase");
tombolCancel.addEventListener("click", function () {
    const inputOwnerName = document.getElementById("inputOwnerName");
    const inputDatabaseName = document.getElementById("inputDatabaseName");
    inputOwnerName.selectedIndex = 0;
    inputDatabaseName.value = "";
    this.removeAttribute('data-new-database');
    window.location.reload();
});

</script>

<script>
    document.querySelector('.add-database-link').addEventListener('click', function(event) {
        var ownerName = document.querySelector('select[name="inputOwnerName"]').value;
        var inputDatabaseName = document.querySelector('input[name="inputDatabaseName"]').value;
        var dataNewDatabase = ownerName + ',' + inputDatabaseName;
        this.setAttribute('data-new-database', dataNewDatabase);
    });

    $(document).ready(function() {
        $('.add-database-link').click(function(event) {
            event.preventDefault();

            var dataNewDatabase = $(this).data('new-database').split(',');
            var ownerName = dataNewDatabase[0];
            var databaseName = dataNewDatabase[1];
            console.log({owner: ownerName, database:databaseName})

            if (confirm("Anda yakin ingin menambahkan Database baru?")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.createNewDatabase') }}'
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
                        'name': 'ownerName',
                        'type': 'hidden',
                        'value': ownerName
                    }),
                    $('<input>', {
                        'name': 'databaseName',
                        'type': 'hidden',
                        'value': databaseName
                    }),
                );

                $('body').append(form);
                form.submit();
            }
        });
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
            console.log({host: hostFtp, username: usernameFtp, password: passwordFtp, cluePassword: cluePasswordFtp})

            if (confirm("Anda yakin ingin menambahkan user MySql baru?")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.createUserMysql') }}'
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
{{-- 




<script>
    $(document).ready(function() {
        $('.delete-record-domain-link').click(function(event) {
            event.preventDefault();

            var domainInfo = $(this).data('domain-info').split(',');
            var innerDomain = domainInfo[0];
            var domainName = domainInfo[1];
            var domainTTL = domainInfo[2];
            var domainType = domainInfo[3];
            var domainRecord = domainInfo[4];

            if (confirm("Anda yakin ingin menghapus domain ini?")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.deleteRecordDomain') }}'
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
                        'name': 'domain',
                        'type': 'hidden',
                        'value': innerDomain
                    }),
                    $('<input>', {
                        'name': 'name',
                        'type': 'hidden',
                        'value': domainName
                    }),
                    $('<input>', {
                        'name': 'ttl',
                        'type': 'hidden',
                        'value': domainTTL
                    }),
                    $('<input>', {
                        'name': 'type',
                        'type': 'hidden',
                        'value': domainType
                    }),
                    $('<input>', {
                        'name': 'record',
                        'type': 'hidden',
                        'value': domainRecord
                    })
                );

                $('body').append(form);
                form.submit();
            }
        });
    });
</script> --}}
@endsection