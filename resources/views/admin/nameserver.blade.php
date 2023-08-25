@extends('layout/admin/app')

@section('konten')
    <div class="bungkus-content">
        <div class="bungkus-header">
            <h5>List Nameserver</h5>
        </div>
        <div class="bungkus-body">
            <div class="items-body" style="max-height: 300px; overflow-y: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nameserver</th>
                            <th scope="col">IP Address</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nameserverData as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <form action="">
                                    <td>
                                        <input
                                            style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;"
                                            type="text" value="{{ $data->nameServer }}" disabled>
                                    </td>
                                    <td>
                                        <input
                                            style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;"
                                            type="text" value="{{ $data->ipNameServer }}" disabled>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger delete-record-domain-link"
                                            data-domain-info="{{ $data->nameServer }},{{ $data->ipNameServer }}">
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
            <h5>Add New Nameserver</h5>
        </div>
        <div class="bungkus-body">
            <div class="items-body">
                <form action="" id="newRecordForm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">New Nameserver</th>
                                <th scope="col">IP v4</th>
                            </tr>
                        </thead>
                        <tbody id="formNewRecord">
                            <tr>
                                <td>
                                    <input
                                        style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;"
                                        type="text" id="nameserverInput" name="nameserverInput">
                                </td>
                                <td>
                                    <input
                                        style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;"
                                        type="text" id="ipAddressInput" name="ipAddressInput">
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
        cancelButton.addEventListener("click", function() {
            document.getElementById("nameserverInput").value = "";
            document.getElementById("ipAddressInput").value = "";
            window.location.reload()
        });
    </script>

    <script>
        document.querySelector('.add-record-domain-link').addEventListener('click', function(event) {
            var nameServer = document.querySelector('input[name="nameserverInput"]').value;
            var ipAddress = document.querySelector('input[name="ipAddressInput"]').value;
            var dataNewNameserver = nameServer + ',' + ipAddress;
            this.setAttribute('data-domain-info', dataNewNameserver);
        });

        $(document).ready(function() {
            $('.add-record-domain-link').click(function(event) {
                event.preventDefault();

                var nameserverInfo = $(this).data('domain-info').split(',');
                var inputNameServer = nameserverInfo[0];
                var inputIpAddress = nameserverInfo[1];
                console.log({
                    nameserver: inputNameServer,
                    ipaddress: inputIpAddress
                })

                if (confirm("Anda yakin ingin menambahkan Nameserver baru?")) {
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': '{{ route('singkuasa.addNewNameserver') }}'
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
                            'name': 'nameserver',
                            'type': 'hidden',
                            'value': inputNameServer
                        }),
                        $('<input>', {
                            'name': 'ipaddress',
                            'type': 'hidden',
                            'value': inputIpAddress
                        })
                    );

                    $('body').append(form);
                    form.submit();
                }
            });
        });
    </script>
    <script>
        @if (session('sukses'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('sukses') }}",
                confirmButtonText: 'Tutup'
            });
        @endif
        @if (session('gagal'))
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
