@extends('layout/admin/app')

@section('konten')
<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>Config Domain</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <thead>
                  <tr style="text-align: justify">
                    <th scope="col">Domain</th>
                    <th scope="col">Edit Zone</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($domainDataArray as $index => $domainData)
                  <tr style="text-align: justify">
                        <td>
                            <a href="http://{{ $domainData }}" target="_blank" rel="noopener noreferrer">
                                {{ $domainData }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('singkuasa.domainRecordManager', ['domain' => $domainData]) }}" class="manage-zone-domain" data-domain-info="">
                                Manage Zone Domain
                            </a>
                        </td>
                        <td> 
                            {{-- <a href="{{ route('singkuasa.domain') }}" class="btn btn-danger hapus-domain" data-domain-info="{{ $domainData }}">
                                Hapus
                            </a> --}}
                            <a href="#" class="btn btn-danger hapus-domain" data-domain-info="{{ $domainData }}">
                                Hapus
                            </a>
                        </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>Add New Domain</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body">
            <form action="{{ route('singkuasa.createNewDomain') }}" method="POST">
                @csrf
                <table class="table">
                    <thead>
                        <tr style="text-align: justify">
                            <th scope="col">Domain</th>
                            <th scope="col">Nameserver 1</th>
                            <th scope="col">Nameserver 2</th>
                        </tr>
                    </thead>
                    <tbody id="formNewRecord">
                        <tr style="text-align: justify">
                            <td>
                                <input type="text" name="domain" >
                            </td>
                            <td>
                                <select name="ns1">
                                    <option value="" selected>---Null---</option>
                                    @foreach ($ns1 as $ns1Value)
                                        <option value="{{ $ns1Value }}">{{ $ns1Value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="ns2">
                                    <option value="" selected>---Null---</option>
                                    @foreach ($ns2 as $ns2Value)
                                        <option value="{{ $ns2Value }}">{{ $ns2Value }}</option>
                                    @endforeach
                                </select>
                            </td>                                                       
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success" id="saveButton">Save</button>
                <button type="button" class="btn btn-warning" id="cancelButton">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('cancelButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Semua value dari form input akan dikosongkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oke!'
        }).then((result) => {
            if (result.isConfirmed) {
                var inputFields = document.querySelectorAll('input[type="text"]');
                inputFields.forEach(function (input) {
                    input.value = ''; // Mengosongkan nilai input
                });
                Swal.fire('Oke!', 'Value form input dikosongkan.', 'success');
            }
        });
    });
</script>
<script>
    document.getElementById('saveButton').addEventListener('click', function(event) {
        var domainInput = document.querySelector('input[name="domain"]');
        var ns1Select = document.querySelector('select[name="ns1"]');
        var ns2Select = document.querySelector('select[name="ns2"]');
        
        if (domainInput.value === "" || ns1Select.value === "null" || ns2Select.value === "null") {
            event.preventDefault(); // Mencegah pengiriman form
            alert("Form Input New Domain tidak boleh null...!");
        }
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
        $('.hapus-domain').click(function(event) {
            event.preventDefault();

            var domainInfo = $(this).data('domain-info').split(',');
            var iniDomain = domainInfo[0];
            console.log({domain: iniDomain});

            if (confirm("Anda yakin ingin menghapus domain ini? Menghapus domain berarti menghapus semua data yang domian ada.")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.deleteDomain') }}'
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
                        'value': iniDomain
                    })
                );

                $('body').append(form);
                form.submit();
            }
        });
    });
</script>
@endsection
{{-- 

<script>
    // Tombol "Cancel" untuk membatalkan penambahan baris
    const cancelButton = document.querySelector(".cancelAddNewRecord");
    cancelButton.addEventListener("click", function () {
        const tbody = document.querySelector("#newRecordForm tbody");
        const rows = tbody.children;
        if (rows.length > 1) {
            tbody.removeChild(rows[rows.length - 0]);
        }
    });
</script>


<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonText: 'Tutup'
        });
    @endif
</script>

<script>
    document.querySelector('.add-record-domain-link').addEventListener('click', function() {
        var innerDomain = document.querySelector('input[name="innerDomain"]').value;
        var childDomain = document.querySelector('input[name="childDomain"]').value;
        var type = document.querySelector('input[name="typeDomain"]').value;
        var record = document.querySelector('input[name="recordDomain"]').value;
        var dataDomainInfo = innerDomain + ',' + childDomain + ',' + type + ',' + record;
        this.setAttribute('data-domain-info', dataDomainInfo);
    });

    $(document).ready(function() {
        $('.add-record-domain-link').click(function(event) {
            event.preventDefault();

            var domainInfo = $(this).data('domain-info').split(',');
            var innerDomain = domainInfo[0];
            var childDomain = domainInfo[1];
            var domainType = domainInfo[2];
            var domainRecord = domainInfo[3];
            console.log({inner: innerDomain, child: childDomain, type: domainType, record: domainRecord})

            if (confirm("Anda yakin ingin menambahkan record domain baru?")) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('singkuasa.addRecordDomain') }}'
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
                        'name': 'inner',
                        'type': 'hidden',
                        'value': innerDomain
                    }),
                    $('<input>', {
                        'name': 'child',
                        'type': 'hidden',
                        'value': childDomain
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
</script>

 --}}