<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserViewController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        //Hapus session dari session(['folderPath' => $folderPath]);
        session()->forget('folderPath');
        return view('admin.index')->with('title', $title);
    }
    // !FTP MANAGEMENT
    public function listFtpClient()
    {
        $title   = "List Ftp User";
        $urlEndPoint = "ftpClient";
        $ch = curl_init();
        $url = env('URL_API') . '/' . $urlEndPoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        if ($data != null) {
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            $ftpUser = $data[0]->payload->datas->datas;
            $directoryRoot = $data[0]->payload->datas->directoryRoot;
            $nestedFolders = $data[0]->payload->datas->nestedFolders;
            $rootDirectory = array_merge($directoryRoot, $nestedFolders);
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'true' : 'false';
            if ($status) {
                return view('admin.listFtpClient', [
                    'title' => $title,
                    'arrayFtpUser' => $ftpUser,
                    'arrayDirectoryRoot' => $rootDirectory,
                    $status => $message
                ]);
            } else {
                // dd($data);
                return view("welcome");
            }
        } else {
            return view("welcome");
        }
        
        
    }
    public function addFtpClient(Request $request)
    {
        $domain = $request->input('host');
        $username = $request->input('username');
        $password = $request->input('password');
        $cluepw = $request->input('cluePassword');

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "createFtpClient";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'domain' => $domain,
            'usernameFtp' => $username,
            'passwordFtp' => $password,
            'cluepwFtp' => $cluepw,
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
            # code...
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'sukses' : 'gagal';
            // dd($statusProses, $pesanProses, $message);
            return redirect()->route('singkuasa.listFtpClient')->with([
                $status => $message,
            ]);
        } else {
            # code...
            return view("welcome");
        }
        
    }
    public function deleteFtpClient(Request $request)
    {
        $hostFtp = $request->input('hostFtp');
        $usernameFtp = $request->input('usernameFtp');
        $cluePwFtp = $request->input('cluePwFtp');
        $directoryFtp = $request->input('directoryFtp');

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "deleteFtpClient";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'hostFtp' => $hostFtp,
            'usernameFtp' => $usernameFtp,
            'cluePwFtp' => $cluePwFtp,
            'directoryFtp' => $directoryFtp,
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
            # code...
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'sukses' : 'gagal';
            // dd($statusProses, $pesanProses, $message);
            return redirect()->route('singkuasa.listFtpClient')->with([
                $status => $message,
            ]);
        } else {
            # code...
            return view("welcome");
        }
        
    }
    // !DOMAIN MANAGEMENT 
    public function allDomainAndNameserver(){
        $title = "Domain Manager";
    
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        
        // Get data from getAllDomain endpoint
        $getAllDomainEndpoint = "getDataDomain";
        $getAllDomainData = [
            'passwordSudo' => $passwordSudo,
        ];
        $getAllDomainDataJson = json_encode($getAllDomainData);
        $ch1 = curl_init();
        $getAllDomainUrl = env('URL_API') . '/' . $getAllDomainEndpoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch1, CURLOPT_URL, $getAllDomainUrl);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $getAllDomainDataJson);
        $headers1 = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $getAllDomainResponse = curl_exec($ch1);
        curl_close($ch1);
        $getAllDomainData = json_decode($getAllDomainResponse);
        $getAllNameserverEndpoint = "getAllNameserver";
        $getAllNameserverData = [
            'passwordSudo' => $passwordSudo,
        ];
        $getAllNameserverDataJson = json_encode($getAllNameserverData);
        $ch2 = curl_init();
        $getAllNameserverUrl = env('URL_API') . '/' . $getAllNameserverEndpoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch2, CURLOPT_URL, $getAllNameserverUrl);
        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $getAllNameserverDataJson);
        $headers2 = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $getAllNameserverResponse = curl_exec($ch2);
        curl_close($ch2);
        $getAllNameserverData = json_decode($getAllNameserverResponse);
        if ($getAllDomainData != null && $getAllNameserverData != null) {
            # code...
            $domainDataArray = $getAllDomainData[0]->payload->datas;
            $filteredDomainDataArray = array_filter($domainDataArray, function($domain) {
                return !(strpos($domain, '.') === 0 && substr($domain, -4) === '.swp');
            });
            $nameserverDataArray = $getAllNameserverData[0]->payload->datas;
        
            $ns1Array = [];
            $ns2Array = [];

            foreach ($nameserverDataArray as $domain) {
                if (strpos($domain, 'ns1') !== false) {
                    $ns1Array[] = $domain;
                } elseif (strpos($domain, 'ns2') !== false) {
                    $ns2Array[] = $domain;
                }
            }
            return view('admin.domainList', [
                'title' => $title,
                'domainDataArray' => $filteredDomainDataArray,
                'ns1' => $ns1Array,
                'ns2' => $ns2Array
            ]);
        } else {
            return view("welcome");
        }
        
    }
    public function domainRecordManager($domain)
    {
        // dd($domain);
        $title = "Domain Manager";

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        // $domain = "lokalserversatu.lap";
        $urlEndPoint = "getDomain";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'domain' => $domain
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
            $domain = $data[0]->payload->datas->serverDomain;
            $innerDomain = rtrim($domain, '.');
            $dataDomainLines = explode("\n", $data[0]->payload->datas->dataDomain);
            $domainDataArray = [];
    
            foreach ($dataDomainLines as $line) {
                $line = trim($line);
                if ($line !== '') {
                    $parts = preg_split('/\s+/', $line, 5);
                    if (count($parts) >= 5) {
                        $name = $parts[0];
                        $ttl = $parts[1];
                        $type = $parts[3];
                        $record = substr($parts[4], 0, 1000);
    
                        $domainDataArray[] = [
                            'name' => $name,
                            'ttl' => $ttl,
                            'type' => $type,
                            'record' => $record
                        ];
                    }
                }
            }
            # code...
            return view('admin.domainRecordManager', [
                'title' => $title,
                'innerDomain' => $innerDomain,
                'domainDataArray' => $domainDataArray
            ]);
        } else {
            # code...
            return view("welcome");
        }
        
    }
    public function deleteRecordDomain(Request $request)
    {
        $inputDomain = $request->input('domain');
        $inputName   = $request->input('name');
        $inputTTL    = $request->input('ttl');
        $inputType   = $request->input('type');
        $inputRecord = $request->input('record');
        $domain = rtrim($inputDomain, '.');

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "deleteDomain";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'domain' => $domain,
            'name' => $inputName, 
            'ttl' => $inputTTL, 
            'type' => $inputType, 
            'record' => $inputRecord,
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
        $statusProses = $data[0]->payload->datas->status;
        $pesanProses = $data[0]->payload->datas->pesan;
        $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
        $status       = $statusProses ? 'sukses' : 'gagal';
        return redirect()->route('singkuasa.domainRecordManager', ['domain' => $domain])->with([
            $status => $message,
        ]);        
    }
    public function addRecordDomain(Request $request)
    {
        $inputDomain = $request->input('inner');
        $domain = rtrim($inputDomain, '.');
        $inputSubdomain = $request->input('child');
        $inputTTL    = 14400;
        $inputType   = $request->input('type');
        $inputRecord = $request->input('record');
        
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "addRecordDomain";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'domain' => $domain,
            'subDomain' => $inputSubdomain, 
            'ttl' => $inputTTL,
            'tipe' => $inputType, 
            'record' => $inputRecord,
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
        $statusProses = $data[0]->payload->datas->status;
        $pesanProses = $data[0]->payload->datas->pesan;
        $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
        $status       = $statusProses ? 'sukses' : 'gagal';
        return redirect()->route('singkuasa.domainRecordManager', ['domain' => $domain])->with([
            $status => $message,
        ]);        
    }
    public function createNewDomain(Request $request)
    {
        $domain = $request->input('domain');
        $ns1 = $request->input('ns1');
        $ns2 = $request->input('ns2');
        $title = "Domain Manager";

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "createNewDomain";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'domain' => $domain,
            'ns1' => $ns1,
            'ns2' => $ns2,
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

        dd($data);
        $statusProses = $data[0]->payload->datas->status;
        $pesanProses = $data[0]->payload->datas->pesan;
        $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
        $status       = $statusProses ? 'sukses' : 'gagal';
        return redirect()->route('singkuasa.domain')->with([
            $status => $message,
        ]); 
    }
    public function deleteDomain(Request $request)
    {
        $domain = $request->input('domain');
        $title = "Domain Manager";

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "deleteAllDataDomain";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'domain' => $domain,
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
        $statusProses = $data[0]->payload->datas->status;
        $pesanProses = $data[0]->payload->datas->pesan;
        $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
        $status       = $statusProses ? 'sukses' : 'gagal';
        return redirect()->route('singkuasa.domain')->with([
            $status => $message,
        ]); 
    }
    // !NAMESERVER MANAGEMENT 
    public static function nameserver(){
        $title = "Nameserver Manager";

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "getNameserverConfig";
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
            $nameserverData = $data[0]->payload->datas->data;
            return view('admin.nameserver', [
                'title' => $title,
                'nameserverData' => $nameserverData
            ]);
        } else {
            return view("welcome");
        }
        
    }
    public static function addNewNameserver(Request $request){
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $nameserver   = $request->input("nameserver");
        $ipaddress   = $request->input("ipaddress");
        $urlEndPoint = "addNewNameserver";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'nameserver' => $nameserver,
            'ipaddress' => $ipaddress
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses  = $data[0]->payload->datas->pesan;
            $message      = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'sukses' : 'gagal';
            return redirect()->route('singkuasa.nameserver')->with([
                $status => $message,
            ]);
        } else {
            return view("welcome");
        }
        
    }
    // !SSL MANAGEMENT 
    public function ssl()
    {
        $title = "SSL Manager";
        return view('admin.index')->with('title', $title);
    }
    // !APP SETUP
    public function setupApp()
    {
        $title = "Setup App";

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "getAllDomain";
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses  = $data[0]->payload->datas->pesan;
            $domain       = $data[0]->payload->datas->domain;
            $message      = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'sukses' : 'gagal';
            return view('admin.setupApp', [
                'title' => $title,
                $status => $message,
                "domain" => $domain
            ]);
        } else {
            return view("welcome");
        }
        
    }
    public function setupWp(Request $request)
    {
        dd($request->input());
    }
    // !DATABASE MANAGEMENT 
    public function getAllDatabase(){
        $title = "Database Manager";
        $urlEndPoint = "getTabelDatabase";
        $ch = curl_init();
        $url = env('URL_API') . '/' . $urlEndPoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        if ($data != null) {
            $dataOwner = $data[0]->payload->datas->dataOwner;
            $database = $data[0]->payload->datas->dataDatabase;
            $status = $data[0]->payload->datas->status;
            if (!$status) {
                return view("welcome");
            } else {
                return view('admin.databaseList', [
                    'title' => $title,
                    'dataOwner' => $dataOwner,
                    'database' => $database,
                ]);
            }
        } else {
            return view("welcome");
        }
        
    }
    public function createUserMysql(Request $request)
    {
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $host = $request->input("host");
        $username = $request->input("username");
        $password = $request->input("password");
        $cluePassword = $request->input("cluePassword");
        $urlEndPoint = "createUserMysql";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'host' => $host, 
            'username' => $username, 
            'password' => $password, 
            'ciriPassword' => $cluePassword
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses  = $data[0]->payload->datas->pesan;
            $message      = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'sukses' : 'gagal';
            return redirect()->route('singkuasa.getAllDatabase')->with([
                $status => $message,
            ]);
        } else {
            return view("welcome");
        }
        
    }
    public function createNewDatabase(Request $request)
    {
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $ownerName = $request->input("ownerName");
        $databaseName = $request->input("databaseName");
        $urlEndPoint = "createNewDatabase";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'ownerName' => $ownerName, 
            'databaseName' => $databaseName, 
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses  = $data[0]->payload->datas->pesan;
            $message      = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status       = $statusProses ? 'sukses' : 'gagal';
            return redirect()->route('singkuasa.getAllDatabase')->with([
                $status => $message,
            ]);
        } else {
            return view("welcome");
        }
        
    }
    public function allDomain(){
        $title = "Domain Manager";

        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "getAllDomain";
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
            $domainDataArray = $data[0]->payload->datas;
            return view('admin.domainList', [
                'title' => $title,
                'domainDataArray' => $domainDataArray
            ]);
        } else {
            return view("welcome");
        }
        
    }
}