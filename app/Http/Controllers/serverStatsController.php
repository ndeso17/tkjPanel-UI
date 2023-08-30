<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class serverStatsController extends Controller
{
    //
    public function serverStats()
    {
        session()->forget('active_menu');
        session(['active_menu' => "statusServer"]);
        $active_menu = session('active_menu');
        $title = "Server Stats";
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "serverStats";
        $postData = [
            'passwordSudo' => $passwordSudo,
        ];
        $postDataJson = json_encode($postData);
        $ch = curl_init();
        $url = env('URL_API') . '/' . $urlEndPoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
        $headers = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        // dd($data);
        if ($data != null) {
            $networkTraffic = $data[0]->payload->datas->networkTraffic;
            // dd($networkTraffic);
            // $ineterfaceNetwork = $data[0]->payload->datas->infoNetwork;
            
            return view("admin.serverStats")->with('title', $title)->with('networkTraffic', $networkTraffic)->with('active_menu', $active_menu);
        } else {
            return view("welcome");
        }   
    }
    public function getServerStatsRealtime(Request $request): JsonResponse
    {
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "serverStats";
        $postData = [
            'passwordSudo' => $passwordSudo,
        ];
        $postDataJson = json_encode($postData);
        $ch = curl_init();
        $url = env('URL_API') . '/' . $urlEndPoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
        $headers = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        if ($data != null) {
            $networkTraffic = $data[0]->payload->datas->networkTraffic;
            $serverUptime = $data[0]->payload->datas->lifeServerUptime;
            $uptimeArray = explode(', ', $serverUptime);
            $hours = 0;
            $minutes = 0;
            $seconds = 0;
            foreach ($uptimeArray as $uptimePart) {
                if (strpos($uptimePart, 'jam') !== false) {
                    $hours = (int) $uptimePart;
                } elseif (strpos($uptimePart, 'menit') !== false) {
                    $minutes = (int) $uptimePart;
                } elseif (strpos($uptimePart, 'detik') !== false) {
                    $seconds = (float) $uptimePart;
                }
            }
            $totalUptimeInSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
            $cpuStats = $data[0]->payload->datas->infoCpus;
            //Swap
            $totalSwap = $data[0]->payload->datas->totalSwap;
            $freeSwap = $data[0]->payload->datas->freeSwap;
            $usedSwap = $data[0]->payload->datas->usedSwap;
            $swapInGB  = [$totalSwap, $freeSwap, $usedSwap];
            $presentaseFreeSwap = $data[0]->payload->datas->presentaseFreeSwap;
            $presentaseUsedSwap = $data[0]->payload->datas->presentaseUsedSwap;
            $swapInPercent      = [$presentaseFreeSwap, $presentaseUsedSwap];
            //Memory
            $totalRamGb = $data[0]->payload->datas->totalRamGb;
            $totalFreeRamGb = $data[0]->payload->datas->totalFreeRamGb;
            $totalFreeRamPersen = $data[0]->payload->datas->totalFreeRamPersen;
            $totalUsedRamGb = $data[0]->payload->datas->totalUsedRamGb;
            $totalUsedRamPersen = $data[0]->payload->datas->totalUsedRamPersen;
            $ramInGB            = [$totalRamGb, $totalFreeRamGb, $totalUsedRamGb];
            $ramInPercent            = [$totalFreeRamPersen, $totalUsedRamPersen];
            //CPUs
            $speedCpuAllCore = $data[0]->payload->datas->speedCpuAllCore;
            $modelCpu = $data[0]->payload->datas->modelCpu;
            //OS
            $releaseOs = $data[0]->payload->datas->releaseOs;
            $versiOs = $data[0]->payload->datas->versiOs;
            $tipeOs = $data[0]->payload->datas->tipeOs;
            //Disk
            $diskInfo = $data[0]->payload->datas->infoDisk;
            $groupedDiskInfo = [];
            foreach ($diskInfo as $disk) {
                $mountpoint = $disk->mountpoint;
                
                if (!isset($groupedDiskInfo[$mountpoint])) {
                    $groupedDiskInfo[$mountpoint] = [];
                }
                
                $groupedDiskInfo[$mountpoint][] = $disk;
            }
            //Get Log From File 
            $apacheLogPath = "/var/log/apache2/other_vhosts_access.log";

            function getLogFromFile($logPath) {
                if (file_exists($logPath)) {
                    return file_get_contents($logPath);
                } else {
                    return "Log file not found";
                }
            }
            $apacheLog = getLogFromFile($apacheLogPath);
            $apacheJsonOutput = json_encode($apacheLog, JSON_PRETTY_PRINT);

            // $mysqlLogPath = "/var/log/mysql/error.log";
            // $fileContentArrayMysql = file($mysqlLogPath);
            // foreach ($fileContentArrayMysql as $line) {
            //     $jsonOutput = json_encode($line, JSON_PRETTY_PRINT);
            // }
            $mysqlLogPath = "/var/log/mysql/error.log";
            $previousLines = array();
            $fileContentArrayMysql = file($mysqlLogPath);

            foreach ($fileContentArrayMysql as $line) {
                if (!in_array($line, $previousLines)) {
                    $jsonOutput = json_encode($line, JSON_PRETTY_PRINT);
                    array_push($previousLines, $line);
                }
            }

            $bindLogPath = "/var/log/syslog";
            $fileContentArray = file($bindLogPath);
            foreach ($fileContentArray as $line) {
                $bindLogJsonOutput = json_encode($line, JSON_PRETTY_PRINT);
            }
            return response()->json([
                'networkTraffic' => $networkTraffic,
                'serverUptime' => $totalUptimeInSeconds,
                'cpuStats' => $cpuStats,
                'swapInGB' => $swapInGB,
                'swapInPercent' => $swapInPercent,
                'ramInGB' => $ramInGB,
                'ramInPercent' => $ramInPercent,
                'speedCpuAllCore' => $speedCpuAllCore,
                'modelCpu' => $modelCpu,
                'releaseOs' => $releaseOs,
                'versiOs' => $versiOs,
                'tipeOs' => $tipeOs,
                'storage' => $groupedDiskInfo,
                'mysqlLog' => $jsonOutput,
                'bindLog' => $bindLogJsonOutput,
            ]);
        } else {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }
}
