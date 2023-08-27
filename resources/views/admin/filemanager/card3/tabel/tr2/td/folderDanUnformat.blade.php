@if ($item['size'] == 'Folder')
    <a href="#" data-subFolder="{{ $item['name'] }}" class="subFolder-link">
        <div class="font-weight-bold text-secondary">
            <i style="vertical-align: middle; margin-right: 5px;" class='bx bxs-folder me-2 font-24 text-secondary'></i>
            <span>{{ $item['name'] }}</span>
        </div>
    </a>
@elseif ($item['size'] != 'Folder')
    <div class="font-weight-bold text-secondary">
        <i style="vertical-align: middle; margin-right: 5px;" class='bx bx-file-blank me-2 font-24 text-secondary'></i>
        <span>{{ $item['name'] }}</span>
    </div>
@else
    <div class="font-weight-bold text-secondary">
        <i style="vertical-align: middle; margin-right: 5px;" class='bx bxs-folder me-2 font-24 text-secondary'></i>
        <span>{{ $item['name'] }}</span>
    </div>
@endif
