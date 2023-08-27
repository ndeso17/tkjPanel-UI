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
                    <a href="#" class="list-group-item py-1 folder-link" data-folder="{{ $item }}">
                        <i class="bx bx-folder me-2"></i>
                        <span>{{ $item }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
