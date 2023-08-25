@extends('layout/admin/app')

@section('konten')
<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>Record Domain</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">TTL</th>
                    <th scope="col">Type</th>
                    <th scope="col">Record</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($domainDataArray as $index => $domainData)
                  <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <form action="">
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $domainData['name'] }}" disabled>
                            <p style="text-align: right">{{ $domainData['name'] }}.{{ $innerDomain }}</p>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $domainData['ttl'] }}" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $domainData['type'] }}" disabled>
                        </td>
                        <td>
                            @if ($domainData['type'] != 'MX')
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $domainData['record'] }}" disabled>
                            @else
                                <p style="text-align: left">
                                    Priority: {{ $domainData['record'] }}
                                </p>
                                <input type="hidden" name="record" value="{{ $domainData['record'] }}">
                                <p style="text-align: left">
                                    Destination: {{ $innerDomain }}
                                </p>
                            @endif
                        
                        </td>                        
                        <td>
                            <a href="#" class="btn btn-danger delete-record-domain-link" data-domain-info="{{ $innerDomain }},{{ $domainData['name'] }},{{ $domainData['ttl'] }},{{ $domainData['type'] }},{{ $domainData['record'] }}">
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
        <h5>Add New Sub Domain</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body">
            <form action="" id="newRecordForm">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Inner Domain</th>
                            <th scope="col">Child Domain</th>
                            <th scope="col">Type</th>
                            <th scope="col">Record</th>
                        </tr>
                    </thead>
                    <tbody id="formNewRecord">
                        <tr>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" name="innerDomain" value="{{ $innerDomain }}" disabled>
                            </td>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" name="childDomain">
                                <p class="combined-value " data-row-id="1" style="text-align: right">{{ $innerDomain }}</p>
                            </td>
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" name="typeDomain" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').toUpperCase();">
                            </td>                            
                            <td>
                                <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" name="recordDomain">
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
        if (event.target.name === "innerDomain" || event.target.name === "childDomain") {
            const innerDomainValue = event.target.closest('tr').querySelector('input[name="innerDomain"]').value;
            const childDomainValue = event.target.closest('tr').querySelector('input[name="childDomain"]').value;
            const combinedValue = childDomainValue + '.' + innerDomainValue;

            const rowId = event.target.closest('tr').querySelector('.combined-value').getAttribute('data-row-id');
            const combinedValueParagraph = document.querySelector(`.combined-value[data-row-id="${rowId}"]`);
            combinedValueParagraph.textContent = combinedValue;
        }
    });
</script>

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
</script>
@endsection