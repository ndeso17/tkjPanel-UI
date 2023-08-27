<tr>
    <td>
        <div class="d-flex align-items-center">
            @if ($item['extension'] == 'php')
                @include('admin.filemanager.card3.tabel.tr2.td.divPhp')
            @elseif ($item['extension'] == 'js')
                @include('admin.filemanager.card3.tabel.tr2.td.divJs')
            @elseif ($item['extension'] == 'json')
                @include('admin.filemanager.card3.tabel.tr2.td.divJson')
            @elseif ($item['extension'] == 'html')
                @include('admin.filemanager.card3.tabel.tr2.td.divHtml')
            @elseif ($item['extension'] == 'css')
                @include('admin.filemanager.card3.tabel.tr2.td.divCss')
            @elseif ($item['extension'] == 'sql')
                @include('admin.filemanager.card3.tabel.tr2.td.divSql')
            @elseif (
                $item['extension'] == 'jpg' ||
                    $item['extension'] == 'jpeg' ||
                    $item['extension'] == 'png' ||
                    $item['extension'] == 'svg' ||
                    $item['extension'] == 'gif')
                @include('admin.filemanager.card3.tabel.tr2.td.divImage')
            @else
                @include('admin.filemanager.card3.tabel.tr2.td.folderDanUnformat')
            @endif
        </div>
    </td>
    <td>{{ $item['size'] }}</td>
    <td>{{ $item['permission'] }}</td>
    <td>{{ $item['updated_at'] }}</td>
    <td title="{{ implode(', ', $item['owner']) }}">{{ $item['grup'] }}
    </td>
    <td>
        @if ($item['size'] == 'Folder')
            <a class="me-2 font-24 renameFiFo" style="text-decoration: none; color: black;" href="#"
                title="Rename {{ $item['name'] }}" data-target="#editModal" data-name="{{ $folderPathNow }}"
                data-original-name="{{ $item['name'] }}">
                <i class='bx bx-edit-alt'></i>
            </a>
            <a class="me-2 font-24 classDeleteFiFo" target-delete="{{ $folderPathNow . '/' . $item['name'] }}"
                style="text-decoration: none; color: black;" href="#" title="Delete {{ $item['name'] }}">
                <i class='bx bxs-trash'></i>
            </a>
        @else
            <a class="me-2 font-24 renameFiFo" style="text-decoration: none; color: black;" href="#"
                title="Rename {{ $item['name'] }}" data-toggle="modal" data-target="#editModal"
                data-name="{{ $folderPathNow }}" data-original-name="{{ $item['name'] }}">
                <i class='bx bx-edit-alt'></i>
            </a>
            <a class="me-2 font-24 editFile" target="_blank" target-edit="{{ $folderPathNow . '/' . $item['name'] }}"
                style="text-decoration: none; color: black;" href="#" title="Edit {{ $item['name'] }}">
                <i class='bx bxs-edit'></i>
            </a>
            <a class="me-2 font-24 linkDownload" data-fileDownload="{{ $item['name'] }}"
                style="text-decoration: none; color: black;" href="#" title="Download {{ $item['name'] }}">
                <i class='bx bx-cloud-download'></i>
            </a>
            <a class="me-2 font-24 classDeleteFiFo" target-delete="{{ $folderPathNow . '/' . $item['name'] }}"
                style="text-decoration: none; color: black;" href="#" title="Delete {{ $item['name'] }}">
                <i class='bx bxs-trash'></i>
            </a>
        @endif
    </td>
</tr>
