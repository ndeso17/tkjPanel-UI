@extends('layout/admin/app')

@section('konten')
<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>Data Instalasi</h5>
    </div>
    <div class="bungkus-body">
        <div class="items-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <thead>
                  <tr style="text-align: justify">
                    <th scope="col">Domain</th>
                    <th scope="col">App Installed</th>
                    <th scope="col">Admin Login Url</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- @foreach ($domain as $index => $domainData)
                  <tr style="text-align: justify">
                        <td>
                            <a href="http://{{ $domainData }}" target="_blank" rel="noopener noreferrer">
                                {{ $domainData }}
                            </a>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="{{ $domainData['type'] }}" disabled> 
                        </td>
                        <td> 
                            <a href="#" class="btn btn-danger hapus-domain" data-domain-info="{{ $domainData }}">
                                Hapus
                            </a>
                        </td>
                  </tr>
                  @endforeach --}}
                  <tr style="text-align: justify">
                        <td>
                            {{-- <a href="http://{{ $domainData }}" target="_blank" rel="noopener noreferrer">
                                {{ $domainData }}
                            </a> --}}
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="Domain" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="App Installed" disabled>
                        </td>
                        <td>
                            <input style="border: none; background-color: white; font-weight: 100; border-bottom: ridge;border-bottom-style: dotted; color: #212529;" type="text" value="https://" disabled>
                        </td>
                        <td> 
                            {{-- <a href="#" class="btn btn-danger hapus-domain" data-domain-info="{{ $domainData }}">
                                Hapus
                            </a> --}}
                            <a href="#" class="btn btn-danger hapus-domain" data-domain-info="">
                                Hapus
                            </a>
                        </td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="bungkus-content">
    <div class="bungkus-header">
        <h5>Setup Wordpress</h5>
    </div>
    <div class="bungkus-body">
        <form action="{{ route('singkuasa.createNewDomain') }}" method="POST">
            @csrf
            {{-- <div class="form-group">
                <label for="pilihDomain">Domain</label>
                <select class="form-control" id="pilihDomain" name="domain">
                    <option value="" selected></option>
                    @foreach ($domain as $dataDomain)
                        <option value="{{ $dataDomain }}">{{ $dataDomain }}</option>
                    @endforeach
                </select>
            </div> --}}
            <div class="form-group">
                <label for="pilihDomain">Domain</label>
                <select class="form-control" id="pilihDomain" name="domain">
                    <option value="" selected></option>
                    <option value="tkjbulakamaba.biz.id">TKJ Bulakamba Testing</option>
                    @foreach ($domain as $dataDomain)
                        <option value="{{ $dataDomain }}">{{ $dataDomain }}</option>
                    @endforeach
                </select>
                <p id="sslError" style="color: red;"></p>
            </div>            
            <div class="form-group">
                <label for="pilihBahasa">Bahasa</label>
                <select class="form-control" id="pilihBahasa" name="bahasa" disabled>
                    <option value="" selected></option>
                    <option value="indonesia">Indoesia</option>
                    <option value="inggris">Inggris</option>
                </select>
            </div>
            <div class="form-group">
                <label for="usernameWp">Username Wordpress</label>
                <input type="text" class="form-control" id="usernameWp" name="usernameWp" disabled>
            </div>
            <div class="form-group">
                <label for="passwordWp">Password Wordpress</label>
                <input type="password" class="form-control" id="passwordWp" name="passwordWp" disabled>
            </div>
            <div class="form-group">
                <label for="emailAdminWp">Email Admin Wordpress</label>
                <input type="text" class="form-control" id="emailAdminWp" name="emailAdminWp" disabled>
            </div>
            <div class="form-group">
                <label for="namaSitus">Email Admin Wordpress</label>
                <input type="text" class="form-control" id="namaSitus" name="namaSitus" disabled>
            </div>
            <div class="form-group">
                <label for="dbName">Database Wordpress</label>
                <input type="text" class="form-control" id="dbName" name="dbName" disabled>
            </div>
            <div class="form-group">
                <label for="dbUsername">Username Database</label>
                <input type="text" class="form-control" id="dbUsername" name="dbUsername" disabled>
            </div>
            <div class="form-group">
                <label for="dbPassword">Password Database</label>
                <input type="password" class="form-control" id="dbPassword" name="dbPassword" disabled>
            </div>
            <button style="margin-top: 20px;" type="submit" class="btn btn-success" id="saveButton">Save</button>
            <button style="margin-top: 20px;" type="button" class="btn btn-warning" id="cancelButton">Cancel</button>
        </form>
        <div class="items-body">
        </div>
    </div>
</div>

<script>
    // Membuat fungsi untuk memeriksa SSL dari sebuah domain
function checkSSL(domain) {
   const urlChecking = `http://localhost:2005/cekSSL?domain=${domain}`;
   fetch(urlChecking)
      .then(response => {
         if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
         }
         return response.json();
      })
      .then(data => {
         var sslErrorElement = document.getElementById('sslError');
         const statusSSL = data[0].payload.datas.ssl; 
         const pesanSSL = data[0].payload.datas.pesan;
         if (!statusSSL) {
             sslErrorElement.textContent = pesanSSL;
             sslErrorElement.style.color = 'red';
             disableFormInputs(); 
        } else {
             sslErrorElement.textContent = pesanSSL;
             sslErrorElement.style.color = 'green';
             enableFormInputs();
            
         }
      })
      .catch(error => {
         console.error('Ada masalah saat melakukan permintaan:', error);
      });
}

// Fungsi untuk memungkinkan input pada form selanjutnya
function enableFormInputs() {
    // Mengaktifkan input pada form selanjutnya di sini
    document.getElementById('pilihBahasa').disabled = false;
    document.getElementById('usernameWp').disabled = false;
    document.getElementById('passwordWp').disabled = false;
    document.getElementById('emailAdminWp').disabled = false;
    document.getElementById('namaSitus').disabled = false;
    document.getElementById('dbName').disabled = false;
    document.getElementById('dbUsername').disabled = false;
    document.getElementById('dbPassword').disabled = false;
}

// Fungsi untuk menonaktifkan input pada form selanjutnya
function disableFormInputs() {
    // Menonaktifkan input pada form selanjutnya di sini
    document.getElementById('pilihBahasa').disabled = true;
    document.getElementById('usernameWp').disabled = true;
    document.getElementById('passwordWp').disabled = true;
    document.getElementById('emailAdminWp').disabled = true;
    document.getElementById('namaSitus').disabled = true;
    document.getElementById('dbName').disabled = true;
    document.getElementById('dbUsername').disabled = true;
    document.getElementById('dbPassword').disabled = true;
}

// Event listener ketika domain dipilih
document.getElementById('pilihDomain').addEventListener('change', function() {
    var selectedDomain = this.value;
    checkSSL(selectedDomain);
});

</script>
{{-- <script>
    document.getElementById('pilihDomain').addEventListener('change', function () {
        var selectedDomain = this.value;
        var sslErrorElement = document.getElementById('sslError');

        if (selectedDomain !== '') {
            // Lakukan pengecekan SSL di sini, misalnya dengan menggunakan XMLHTTPRequest
            console.log({domain: selectedDomain});
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', 'https://' + selectedDomain, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status !== 200) {
                        sslErrorElement.textContent = 'Domain tidak memiliki SSL (HTTPS).';
                        // Matikan tombol "Save"
                        document.getElementById('saveButton').disabled = true;
                    } else {
                        sslErrorElement.textContent = '';
                        // Aktifkan tombol "Save"
                        document.getElementById('saveButton').disabled = false;
                    }
                }
            };
            xhr.send();
        } else {
            sslErrorElement.textContent = '';
            document.getElementById('saveButton').disabled = false;
        }
    });
</script> --}}

{{-- <script>
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
</script> --}}
@endsection