@extends('layout/admin/app')
@section('konten')
    <div class="col-12">
        <div class="row">
            <div class="col-8 mb-2">
                <div class="card card-shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>
                                    <i class="fa fa-tasks"></i>
                                    System Info <span id="identity"></span>
                                </h6>
                            </div>
                            <div class="col-sm-6" style="text-align: right;">
                                <h6>
                                    <a href="#" id="minimizeButtonSystem" onclick="toggleMinimizeSystem()">
                                        <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="systemInfoBody" style="display: inline-flex;">
                        <div class="col-6">
                            <div class="card-body card-body-rb">
                                <table class="table table-hover text-nowrap unselect" style="font-size: 13px;">
                                    <tr>
                                        <td>Tipe Os</td>
                                        <td><span id="tipeOs">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Versi Os</td>
                                        <td>
                                            <span id="versiOs">-</span>
                                            <span id="versiOsFull" style="display: none;"></span>
                                            <span id="toggleVersiOs" style="cursor: pointer; color: blue;">...</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Release Os</td>
                                        <td><span id="releaseOs">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>CPU Model</td>
                                        <td><span id="cpuModel">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>CPU Speed</td>
                                        <td><span id="cpuSpeed">-</span></td>
                                    </tr>
                                </table>
                                <div id="versiOsExpanded" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card-body card-body-rb">
                                <table class="table table-hover text-nowrap unselect" style="font-size: 13px;">
                                    <tr>
                                        <td>Memory</td>
                                        <td><span id="memory">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Swap</td>
                                        <td><span id="swap">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Storage</td>
                                        <td><span id="storage">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>CPU Core Running</td>
                                        <td><span id="corePersen">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Uptime</td>
                                        <td><span id="serverUptime">-</span></td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 mb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-shadow">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6>
                                            <i class="fa fa-file-text"></i>
                                            Server Log
                                        </h6>
                                    </div>
                                    <div class="col-sm-6" style="text-align: right;">
                                        <h6>
                                            <a href="#" id="minimizeButtonServerLog" onclick="toggleMinimize()">
                                                <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="serverLog" style="display: block">
                                <div class="card-body card-body-rb" id="autoOverFlow"
                                    style="height: 228px; overflow-y: scroll;">
                                    <div class="overflow" id="serverLogContent">
                                        <table class="table table-hover text-nowrap unselect" style="font-size: 12px;">
                                            <tbody id="logTableBody"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="card card-shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>
                                    <span>
                                        <i class="fa fa-area-chart"></i>
                                        Network Traffic Monitor
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <h6>
                                    <select id="iface-name" title="Select Interface" onchange="updateChart()">
                                        @foreach ($networkTraffic as $iface => $data)
                                            <option value="{{ $iface }}">{{ $iface }}</option>
                                        @endforeach
                                    </select>
                                    <a href="#" id="minimizeButtonNTM" onclick="toggleMinimizeNTM()">
                                        <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="networkTrafficMonitor" style="display: block">
                        <div class="card-body card-body-rb">
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="networkTrafficChart" style="width:100%; height: 350px;"></canvas>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p id="selected-interface" style="font-weight: bold; margin: 0;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('servers/serverStats.js') }}"></script>
@endsection
