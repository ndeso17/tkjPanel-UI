@extends('layout/admin/app')

@section('konten')
    <div class="bungkus-content">
        <div class="bungkus-header">
            <h5>File</h5>
        </div>
        <div class="bungkus-body">
            <ul>
                <li>
                    <div class="items-body">
                        <a href="{{ route('singkuasa.fileManager') }}">
                            <div class="item-image">
                                <i class='bx bxs-file-find'></i>
                            </div>
                            <div class="item-nama">
                                <h6>File Manager</h6>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <a href="{{ route('singkuasa.listFtpClient') }}">
                            <div class="item-image">
                                <i class="bx bxs-file-archive"></i>
                            </div>
                            <div class="item-nama">
                                <h6>FTP Server</h6>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bungkus-content">
        <div class="bungkus-header">
            <h5>Domain</h5>
        </div>
        <div class="bungkus-body">
            <ul>
                <li>
                    <div class="items-body">
                        <a href="{{ route('singkuasa.domain') }}">
                            <div class="item-image">
                                <i class='bx bx-globe'></i>
                            </div>
                            <div class="item-nama">
                                <h6>Domain</h6>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <a href="{{ route('singkuasa.nameserver') }}">
                            <div class="item-image">
                                <i class="bx bx-globe-alt"></i>
                            </div>
                            <div class="item-nama">
                                <h6>Nameserver</h6>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <div class="item-image">
                            <i class="bx bx-sitemap"></i>
                        </div>
                        <div class="item-nama">
                            <h6>Virtual Host</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <div class="item-image">
                            <i class="bx bxs-key"></i>
                        </div>
                        <div class="item-nama">
                            <h6>SSL</h6>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bungkus-content">
        <div class="bungkus-header">
            <h5>Aplikasi</h5>
        </div>
        <div class="bungkus-body">
            <ul>
                <li>
                    <a href="{{ route('singkuasa.setupApp') }}">
                        <div class="items-body">
                            <div class="item-image">
                                <i class='bx bxl-wordpress'></i>
                            </div>
                            <div class="item-nama">
                                <h6>Setup Wordpress</h6>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="items-body">
                        <div class="item-image">
                            <i class='bx bxs-book'></i>
                        </div>
                        <div class="item-nama">
                            <h6>Setup Moodle</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <div class="item-image">
                            <i class='bx bxl-nodejs'></i>
                        </div>
                        <div class="item-nama">
                            <h6>Setup Node JS App</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <div class="item-image">
                            <i class="bx bxl-python"></i>
                        </div>
                        <div class="item-nama">
                            <h6>Setup Python App</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="items-body">
                        <div class="item-image">
                            <i class="bx bxl-php"></i>
                        </div>
                        <div class="item-nama">
                            <h6>PHP Selector Version</h6>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bungkus-content">
        <div class="bungkus-header">
            <h5>Database</h5>
        </div>
        <div class="bungkus-body">
            <ul>
                <li>
                    <a href="https://labnaxgrinting.kom/phpmyadmin/">
                        <div class="items-body">
                            <div class="item-image">
                                <i class='bx bxl-php'></i>
                            </div>
                            <div class="item-nama">
                                <h6>PHPMyAdmin</h6>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('singkuasa.getAllDatabase') }}">
                        <div class="items-body">
                            <div class="item-image">
                                <i class='bx bxs-data'></i>
                            </div>
                            <div class="item-nama">
                                <h6>MySql Databases</h6>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection
