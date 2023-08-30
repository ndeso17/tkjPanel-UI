let networkTrafficData = null;
let selectedInterface = null;
let chart;
const serverStatsUrl = document
    .querySelector('meta[name="server-stats-url"]')
    .getAttribute("content");

document.getElementById("iface-name").addEventListener("change", function () {
    selectedInterface = this.value;
    updateChart();
});

document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("networkTrafficChart").getContext("2d");
    chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Receive",
                    data: [],
                    backgroundColor: "#36A2EB",
                },
                {
                    label: "Transmit",
                    data: [],
                    backgroundColor: "#FF6384",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return formatSpeed(value);
                        },
                    },
                },
            },
        },
    });

    fetch(serverStatsUrl)
        .then((response) => response.json())
        .then((data) => {
            if (!data.networkTraffic) {
                console.error("No network traffic data found in response.");
                return;
            }

            networkTrafficData = data.networkTraffic;

            const ifaceSelect = document.getElementById("iface-name");
            ifaceSelect.innerHTML = "";
            for (const iface in networkTrafficData) {
                const option = document.createElement("option");
                option.value = iface;
                option.textContent = iface;
                ifaceSelect.appendChild(option);
            }

            selectedInterface = ifaceSelect.value;
            updateChart();
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });

    setInterval(updateChart, 2000); // Update chart every 2 seconds
});

function updateChart() {
    if (!selectedInterface) return;

    if (document.hidden) return;
    document.getElementById(
        "selected-interface"
    ).textContent = `Selected Interface: ${selectedInterface}`;

    if (!networkTrafficData || !networkTrafficData[selectedInterface]) {
        console.error(
            "Network traffic data for the selected interface is not available."
        );
        return;
    }

    const receiveBytes = parseInt(
        networkTrafficData[selectedInterface].bytes.receive
    );
    const transmitBytes = parseInt(
        networkTrafficData[selectedInterface].bytes.transmit
    );

    if (chart.data.labels.length >= 10) {
        chart.data.labels.shift();
        chart.data.datasets.forEach((dataset) => {
            dataset.data.shift();
        });
    }

    chart.data.labels.push("");
    chart.data.datasets[0].data.push(receiveBytes);
    chart.data.datasets[1].data.push(transmitBytes);

    chart.update();
}

function convertToSpeed(value) {
    if (value < 1000) {
        return value + " bps";
    } else if (value < 1000000) {
        return (value / 1000).toFixed(2) + " kbps";
    } else if (value < 1000000000) {
        return (value / 1000000).toFixed(2) + " Mbps";
    } else {
        return (value / 1000000000).toFixed(2) + " Gbps";
    }
}

function formatSpeed(value) {
    return convertToSpeed(value);
}

// let networkTrafficData = null;
//         let selectedInterface = null;
//         let chart;

//         document.getElementById('iface-name').addEventListener('change', function() {
//             selectedInterface = this.value;
//             updateChart();
//         });

//         document.addEventListener("DOMContentLoaded", function() {
//             const ctx = document.getElementById('networkTrafficChart').getContext('2d');
//             chart = new Chart(ctx, {
//                 type: 'bar',
//                 data: {
//                     labels: [],
//                     datasets: [],
//                 },
//                 options: {
//                     responsive: true,
//                     maintainAspectRatio: false,
//                     scales: {
//                         y: {
//                             beginAtZero: true,
//                             ticks: {
//                                 callback: function(value) {
//                                     return formatSpeed(
//                                         value); // Format y-axis ticks as bps, kbps, Mbps, Gbps
//                                 }
//                             }
//                         }
//                     }
//                 },
//             });

//             selectedInterface = document.getElementById('iface-name').value;
//             updateChart(); // Initial chart update

//             setInterval(updateChart, 2000); // Update chart every 2 seconds
//         });

//         function updateChart() {
//             if (!selectedInterface) return;

//             if (document.hidden) return;
//             document.getElementById('selected-interface').textContent = `Selected Interface: ${selectedInterface}`;
//             fetch()
//                 .then(response => response.json())
//                 .then(data => {
//                     if (!data.networkTraffic) {
//                         console.error('No network traffic data found in response.');
//                         return;
//                     }

//                     networkTrafficData = data.networkTraffic;

//                     if (chart.data.labels.length === 0) {
//                         const labels = Object.keys(networkTrafficData[selectedInterface].bytes.receive);
//                         const datasets = [];

//                         for (const dataKey in networkTrafficData[selectedInterface]) {
//                             if (dataKey !== 'timestamp') {
//                                 for (const dataType in networkTrafficData[selectedInterface][dataKey]) {
//                                     datasets.push({
//                                         label: `${dataKey} ${dataType}`,
//                                         data: [],
//                                         backgroundColor: randomColor(),
//                                     });
//                                 }
//                             }
//                         }

//                         chart.data.labels = labels;
//                         chart.data.datasets = datasets;
//                     }

//                     chart.data.datasets.forEach((dataset) => {
//                         const labelParts = dataset.label.split(' ');
//                         const dataKey = labelParts[0];
//                         const dataType = labelParts[1];
//                         dataset.data = Object.values(networkTrafficData[selectedInterface][dataKey][dataType])
//                             .map(value => {
//                                 return value; // Data already in the required format (bps/kbps/mbps/gbps)
//                             });
//                     });
//                     chart.update();
//                 })
//                 .catch(error => {
//                     console.error('Error fetching data:', error);
//                 });
//         }

//         function randomColor() {
//             return '#' + Math.floor(Math.random() * 16777215).toString(16);
//         }

//         function convertToSpeed(value) {
//             if (value < 1000) {
//                 return value + ' bps';
//             } else if (value < 1000000) {
//                 return (value / 1000).toFixed(2) + ' kbps';
//             } else if (value < 1000000000) {
//                 return (value / 1000000).toFixed(2) + ' Mbps';
//             } else {
//                 return (value / 1000000000).toFixed(2) + ' Gbps';
//             }
//         }

//         function formatSpeed(value) {
//             return convertToSpeed(value);
//         }
function toggleMinimize() {
    var serverLogBody = document.getElementById("serverLog");
    var minimizeButtonServerLog = document.getElementById(
        "minimizeButtonServerLog"
    );

    if (serverLogBody.style.display === "block") {
        serverLogBody.style.display = "none";
        minimizeButtonServerLog.innerHTML =
            '<i class="fa-solid fa-up-right-and-down-left-from-center"></i>';
    } else {
        serverLogBody.style.display = "block";
        minimizeButtonServerLog.innerHTML =
            '<i class="fa-solid fa-down-left-and-up-right-to-center"></i>';
    }
}
function toggleMinimizeSystem() {
    var systemInfoBody = document.getElementById("systemInfoBody");
    var minimizeButtonSystem = document.getElementById("minimizeButtonSystem");

    if (systemInfoBody.style.display === "inline-flex") {
        systemInfoBody.style.display = "none";
        minimizeButtonSystem.innerHTML =
            '<i class="fa-solid fa-up-right-and-down-left-from-center"></i>';
    } else {
        systemInfoBody.style.display = "inline-flex";
        minimizeButtonSystem.innerHTML =
            '<i class="fa-solid fa-down-left-and-up-right-to-center"></i>';
    }
}
function toggleMinimizeNTM() {
    var systemInfoBody = document.getElementById("networkTrafficMonitor");
    var minimizeButtonSystem = document.getElementById("minimizeButtonNTM");

    if (systemInfoBody.style.display === "block") {
        systemInfoBody.style.display = "none";
        minimizeButtonSystem.innerHTML =
            '<i class="fa-solid fa-up-right-and-down-left-from-center"></i>';
    } else {
        systemInfoBody.style.display = "block";
        minimizeButtonSystem.innerHTML =
            '<i class="fa-solid fa-down-left-and-up-right-to-center"></i>';
    }
}
function updateServerStats() {
    fetch(serverStatsUrl)
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                console.error("Terjadi kesalahan:", data.error);
            } else {
                const serverUptimeInSeconds = data.serverUptime;
                const hours = Math.floor(serverUptimeInSeconds / 3600);
                const minutes = Math.floor((serverUptimeInSeconds % 3600) / 60);
                const seconds = serverUptimeInSeconds % 60;
                //?Server log
                //!Mysql Log
                const mysqlLog = data.mysqlLog;
                // console.log(mysqlLog);
                const linesMysqlg = mysqlLog.split("\n");

                const kunciMySql = ["[InnoDB]", "[Server]"];

                const filterOuputMysqlLog = linesMysqlg.filter((line) => {
                    return kunciMySql.some((keyword) => line.includes(keyword));
                });

                const cleandOutPutMysqlLog = filterOuputMysqlLog.map(
                    (output) => {
                        const keyword = kunciMySql.find((keyword) =>
                            output.includes(keyword)
                        );
                        const startIndex = output.indexOf(keyword);
                        const cleanedLine = output
                            .slice(startIndex)
                            .trim()
                            .replace(/\\/g, "");
                        const superCleandLine = cleanedLine.replace('n"', "");
                        return `${superCleandLine}`;
                    }
                );
                let mysqlLogData;
                cleandOutPutMysqlLog.forEach((output) => {
                    mysqlLogData = output;
                });
                // console.log(mysqlLogData);
                //!Bind Log
                const bindLog = data.bindLog;
                const lines = bindLog.split("\n");

                const keywords = ["named", "CRON", "kernel"];

                const filteredOutput = lines.filter((line) => {
                    return keywords.some((keyword) => line.includes(keyword));
                });

                const cleanedOutput = filteredOutput.map((output) => {
                    const keyword = keywords.find((keyword) =>
                        output.includes(keyword)
                    );
                    const startIndex = output.indexOf(keyword);
                    const cleanedLine = output
                        .slice(startIndex)
                        .trim()
                        .replace('\\n"', "");
                    return `${cleanedLine}`;
                });
                let bindLogData;
                cleanedOutput.forEach((output) => {
                    // console.log(output);
                    bindLogData = output;
                });
                // console.log(bindLogData);
                //Log Mysql dan Bind
                let logServerMysqlBind;
                if (
                    bindLogData === "undefined" &&
                    mysqlLogData === "undefined"
                ) {
                    logServerMysqlBind = {
                        mysql: null,
                        bind: null,
                    };
                } else {
                    logServerMysqlBind = {
                        mysql: mysqlLogData,
                        bind: bindLogData,
                    };
                }
                // Mendapatkan referensi ke elemen <tbody>
                const tbody = document.querySelector("#serverLogContent tbody");
                // Iterasi melalui objek logServerMysqlBind
                const logTableBody = document.getElementById("autoOverFlow");
                for (const server in logServerMysqlBind) {
                    if (logServerMysqlBind.hasOwnProperty(server)) {
                        const logValue = logServerMysqlBind[server];
                        // Buat elemen <tr> untuk nilai log server
                        const tr = document.createElement("tr");
                        const td = document.createElement("td");
                        td.textContent = `${server} :  "${logValue}"`;
                        tr.appendChild(td);
                        tbody.appendChild(tr);
                        logTableBody.scrollTop = logTableBody.scrollHeight;
                    }
                }
                //Storage
                const storage = data.storage;
                let mountpointStorage;
                let availableStorage;
                let usedStorage;
                let percentUsedStorage;
                for (const mountpoint in storage) {
                    if (storage.hasOwnProperty(mountpoint)) {
                        const diskArray = storage[mountpoint];
                        const firstDisk = diskArray[0]; // Mengambil disk pertama dari array

                        const available = firstDisk.available;
                        const percentUsed = firstDisk.percentUsed;
                        const used = firstDisk.used;

                        mountpointStorage = mountpoint;
                        availableStorage = available;
                        usedStorage = used;
                        percentUsedStorage = percentUsed;
                    }
                }
                const storageUse = parseFloat(usedStorage.replace("G", ""));
                const storageAvailable = parseFloat(
                    availableStorage.replace("G", "")
                );
                const storageFree = storageAvailable - storageUse;
                const percentStorageFree = (
                    (storageUse / storageAvailable) *
                    100
                ).toFixed(2);
                const dataStorage = `${availableStorage}B, Free ${percentStorageFree}%, Used ${percentUsedStorage}`;
                const dataStorageGB = `${availableStorage}B, Free ${storageFree}GB, Used ${usedStorage}B`;
                const storageElement = document.getElementById("storage");
                storageElement.textContent = dataStorage;
                storageElement.addEventListener("mouseover", function () {
                    storageElement.textContent = dataStorageGB;
                });
                storageElement.addEventListener("mouseout", function () {
                    storageElement.textContent = dataStorage;
                });

                //Versi OS
                const tipeOs = data.tipeOs;
                const tipeOsElement = document.getElementById("tipeOs");
                tipeOsElement.textContent = tipeOs;
                //Versi OS
                const versiOs = data.versiOs;
                const maxDisplayedLength = 30;

                const versiOsElement = document.getElementById("versiOs");
                const versiOsFullElement =
                    document.getElementById("versiOsFull");
                const toggleVersiOsElement =
                    document.getElementById("toggleVersiOs");
                const versiOsExpandedElement =
                    document.getElementById("versiOsExpanded");

                if (versiOs.length <= maxDisplayedLength) {
                    versiOsElement.textContent = versiOs;
                } else {
                    versiOsElement.textContent =
                        versiOs.slice(0, maxDisplayedLength) + " ";
                    versiOsFullElement.textContent = versiOs;
                    toggleVersiOsElement.style.display = "inline";
                }

                toggleVersiOsElement.addEventListener("click", function () {
                    if (versiOsExpandedElement.style.display === "none") {
                        versiOsExpandedElement.textContent = versiOs;
                        versiOsExpandedElement.style.display = "block"; // Tampilkan versi lengkap
                        toggleVersiOsElement.textContent = "Tutup";
                    } else {
                        versiOsExpandedElement.style.display = "none"; // Sembunyikan versi lengkap
                        toggleVersiOsElement.textContent = "...";
                    }
                });
                //Release OS
                const releaseOs = data.releaseOs;
                const releaseOsElement = document.getElementById("releaseOs");
                releaseOsElement.textContent = releaseOs;
                //Model CPU
                const modelCpu = data.modelCpu;
                const modelCpuElement = document.getElementById("cpuModel");
                modelCpuElement.textContent = modelCpu;
                //Speed CPU
                const cpuSpeed = data.speedCpuAllCore;
                const cpuSpeedElement = document.getElementById("cpuSpeed");
                const frequencyInGHz = cpuSpeed / 1000;
                cpuSpeedElement.textContent = frequencyInGHz.toFixed(2) + "GHz";
                //ServerUptime
                const serverUptimeElement =
                    document.getElementById("serverUptime");
                serverUptimeElement.textContent = `${hours} jam, ${minutes} menit, ${seconds.toFixed(
                    2
                )} detik`;
                //CPU Run
                const cpuStats = data.cpuStats;
                const corePersenElement = document.getElementById("corePersen");
                corePersenElement.textContent = cpuStats.join(", ");
                //Swap
                const swapInGB = data.swapInGB.map((value) =>
                    parseFloat(value)
                );
                const swapInPercent = data.swapInPercent;
                const freeSwapInGB = swapInGB[1];
                const freeSwapInPercent = swapInPercent[0];
                const usedSwapInGB = swapInGB[2];
                const usedSwapInPercent = swapInPercent[1];
                const swapElement = document.getElementById("swap");
                swapElement.textContent =
                    swapInGB[0].toFixed() +
                    "GB" +
                    ", " +
                    `Free ${freeSwapInPercent}` +
                    ` Used ${usedSwapInPercent}`;
                swapElement.addEventListener("mouseover", function () {
                    swapElement.textContent =
                        `${swapInGB[0].toFixed()}GB, ` +
                        `Free ${freeSwapInGB}GB, ` +
                        `Used ${usedSwapInGB}GB`;
                });

                // Mengembalikan teks awal saat kursor menjauh dari elemen
                swapElement.addEventListener("mouseout", function () {
                    swapElement.textContent =
                        `${swapInGB[0].toFixed()}GB, ` +
                        `Free ${freeSwapInPercent}, ` +
                        `Used ${usedSwapInPercent}`;
                });
                //RAM
                const ramInGB = data.ramInGB.map((value) => parseFloat(value));
                const ramInPercent = data.ramInPercent;
                const freeRamInGB = ramInGB[1];
                const freeRamInPercent = ramInPercent[0];
                const usedRamInGB = ramInGB[2];
                const usedRamInPercent = ramInPercent[1];
                const ramElement = document.getElementById("memory");
                ramElement.textContent =
                    ramInGB[0].toFixed() +
                    "GB" +
                    ", " +
                    `Free ${freeRamInPercent}` +
                    ` Used ${usedRamInPercent}`;
                ramElement.addEventListener("mouseover", function () {
                    ramElement.textContent =
                        `${ramInGB[0].toFixed()}GB, ` +
                        `Free ${freeRamInGB}GB, ` +
                        `Used ${usedRamInGB}GB`;
                });

                // Mengembalikan teks awal saat kursor menjauh dari elemen
                ramElement.addEventListener("mouseout", function () {
                    ramElement.textContent =
                        `${ramInGB[0].toFixed()}GB, ` +
                        `Free ${freeRamInPercent}, ` +
                        `Used ${usedRamInPercent}`;
                });
            }
        })
        .catch((error) => {
            console.error("Terjadi kesalahan:", error);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    updateServerStats();
    setInterval(updateServerStats, 5000); // Mengambil data setiap 5 detik
});
