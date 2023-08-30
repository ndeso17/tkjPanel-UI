<nav class="nav">
    <div>
        <a href="#" class="nav_logo">
            <i class='bx bx-layer nav_logo-icon'></i>
            <span class="nav_logo-name">tkjPanel</span>
        </a>
        <hr>
        <div class="nav_list">
            {{-- <a href="{{ route('singkuasa.index') }}" class="nav_link"> --}}
            <a href="{{ route('singkuasa.index') }}"
                class="nav_link{{ session('active_menu') == 'indexTool' ? ' active' : '' }}">
                <i class='bx bx-wrench nav_icon'></i>
                <span class="nav_name">Tools</span>
            </a>
            <a href="#" class="nav_link">
                <i class='bx bx-grid-alt nav_icon'></i>
                <span class="nav_name">Aplikasi</span>
            </a>
            <a href="{{ route('singkuasa.fileManager') }}" class="nav_link">
                <i class='bx bx-folder nav_icon'></i>
                <span class="nav_name">File</span>
            </a>
            {{-- <a href="{{ route('singkuasa.serverStats') }}" class="nav_link"> --}}
            <a href="{{ route('singkuasa.serverStats') }}"
                class="nav_link{{ session('active_menu') == 'statusServer' ? ' active' : '' }}">
                <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
                <span class="nav_name">Status Server</span>
            </a>
        </div>
    </div>
    <a href="#" class="nav_link">
        <i class='bx bx-log-out nav_icon'></i>
        <span class="nav_name">
            SignOut
        </span>
    </a>
</nav>
<script>
    const navLinks = document.querySelectorAll(".nav_link");

    navLinks.forEach((link) => {
        link.addEventListener("click", () => {
            // Hapus kelas 'active' dari semua elemen menu
            navLinks.forEach((navLink) => {
                navLink.classList.remove("active");
            });

            // Tambahkan kelas 'active' ke elemen menu yang diklik
            link.classList.add("active");
        });
    });
</script>
