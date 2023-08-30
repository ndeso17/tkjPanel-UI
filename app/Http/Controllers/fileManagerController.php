<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class fileManagerController extends Controller
{
    public function index(Request $request)
    {   
        return view('filemanager');
    }
    public function fileManager(Request $request)
    {
        $rootDirectory = "/home/tkjPanel";
        $directoryContents = scandir($rootDirectory);
        $filteredContents = array_filter($directoryContents, function ($item) {
            return $item !== '.' && $item !== '..';
        });
        $unformatExtensions = []; 
        $unformatFilesCount = 0; 
        $totalUnformatSize = 0;
        $videoExtension = []; 
        $videoFileCount = 0; 
        $totalVideoFileSize = 0;
        $imageExtension = []; 
        $imageFileCount = 0; 
        $totalImageFileSize = 0;
        $sqlExtension = []; 
        $sqlFileCount = 0; 
        $totalSqlFileSize = 0;
        $jsExtension = []; 
        $jsFileCount = 0; 
        $totalJsFileSize = 0;
        $cssExtension = []; 
        $cssFileCount = 0; 
        $totalCssFileSize = 0;
        $htmlExtension = []; 
        $htmlFileCount = 0; 
        $totalHtmlFileSize = 0;
        $phpExtension = []; 
        $phpFileCount = 0; 
        $totalPhpFileSize = 0;
        $this->countFilesAndExtensions(
            $rootDirectory,
            $unformatExtensions, $unformatFilesCount, $totalUnformatSize,
            $videoExtension, $videoFileCount, $totalVideoFileSize,
            $imageExtension, $imageFileCount, $totalImageFileSize,
            $sqlExtension, $sqlFileCount, $totalSqlFileSize,
            $jsExtension, $jsFileCount, $totalJsFileSize,
            $cssExtension, $cssFileCount, $totalCssFileSize,
            $htmlExtension, $htmlFileCount, $totalHtmlFileSize,
            $phpExtension, $phpFileCount, $totalPhpFileSize
        );
        $freeSpace = disk_free_space($rootDirectory);
        $usedSpace = disk_total_space($rootDirectory) - $freeSpace;

        $formattedUnformatSize = $this->formatBytes($totalUnformatSize);
        $freeSpaceFormatted = $this->formatBytes($freeSpace);
        $usedSpaceFormatted = $this->formatBytes($usedSpace);
        $formattedTotalVideoFileSize = $this->formatBytes($totalVideoFileSize);
        $formattedTotalImageFileSize = $this->formatBytes($totalImageFileSize);
        $formattedTotalSqlFileSize = $this->formatBytes($totalSqlFileSize);
        $formattedTotalJsFileSize = $this->formatBytes($totalJsFileSize);
        $formattedTotalCssFileSize = $this->formatBytes($totalCssFileSize);
        $formattedTotalHtmlFileSize = $this->formatBytes($totalHtmlFileSize);
        $formattedTotalPhpFileSize = $this->formatBytes($totalPhpFileSize);
        
        $selectedFolder = $request->input('folder');
        $selectedSubFolder = $request->input('subfolder');
        $folderPathSesion = session('folderPath');
        $folderContents = [];

        if ($selectedFolder) {
            $folderPath = "$rootDirectory/$selectedFolder";
            //Simpan data folderPath Pada sesi yang nantinya akan digunakan kembali
            session(['folderPath' => $folderPath]);
            $folderContents = scandir($folderPath);
            $folderContents = array_filter($folderContents, function ($item) {
                return $item !== '.' && $item !== '..';
            });
            
            $filesWithPermission = [];
            
            foreach ($folderContents as $item) {
                $filePath = "$folderPath/$item";
                $permission = substr(sprintf('%o', fileperms($filePath)), -4);
                $createdAt = date("d/m/Y H:i:s", filectime($filePath));
                $updatedAt = date("d/m/Y H:i:s", filemtime($filePath));
                if (is_file($filePath)) {
                    $size = $this->formatBytes(filesize($filePath));
                } else {
                    $size = "Folder";
                }
                $groupId = filegroup($filePath);
                $group = $this->getGroupName($groupId);
                $groupUsers = $this->getGroupUsers($group);
                $extension = pathinfo($item, PATHINFO_EXTENSION);

                $filesWithPermission[] = [
                    'name' => $item,
                    'permission' => $permission,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'size' => $size,
                    'grup'=> $group,
                    'owner'=> $groupUsers,
                    'extension' => $extension,
                ];
            }            
        } elseif ($selectedSubFolder || $folderPathSesion) {
            $folderPath = session('folderPath');
            $targetScan     = $folderPath . '/' . $selectedSubFolder;
            // dd($targetScan);
            $subFolderContents = scandir($targetScan);
            session(['folderPath' => $targetScan]);
            $subFolderContents = array_filter($subFolderContents, function ($item) {
                return $item !== '.';
            });
            // dd($subFolderContents);
            $filesSubFolderWithPermission = [];            
            foreach ($subFolderContents as $item) {
                $filePath = "$targetScan/$item";
                $permission = substr(sprintf('%o', fileperms($filePath)), -4);
                $createdAt = date("d/m/Y H:i:s", filectime($filePath));
                $updatedAt = date("d/m/Y H:i:s", filemtime($filePath));
                if (is_file($filePath)) {
                    $size = $this->formatBytes(filesize($filePath));
                } else {
                    $size = "Folder";
                }
                $groupId = filegroup($filePath);
                $group = $this->getGroupName($groupId);
                $groupUsers = $this->getGroupUsers($group);
                $extension = pathinfo($item, PATHINFO_EXTENSION);

                $filesSubFolderWithPermission[] = [
                    'name' => $item,
                    'permission' => $permission,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'size' => $size,
                    'grup'=> $group,
                    'owner'=> $groupUsers,
                    'extension' => $extension,
                ];
            }
        } 
        // elseif ($redirectFromDownloadFile) {
        //     # code...
        // }
        $dataSizeFile = [
            'unformat'=>$totalUnformatSize,
            'video'=>$totalVideoFileSize,
            'image'=>$totalImageFileSize,
            'sql'=>$totalSqlFileSize,
            'js'=>$totalJsFileSize,
            'css'=>$totalCssFileSize,
            'html'=>$totalHtmlFileSize,
            'php'=>$totalPhpFileSize,
        ];
        // dd($dataSizeFile);
        $successMessage = Session::get('success');
        $errorMessage = Session::get('failed');
        $folderPathNow = session('folderPath');
        return view('admin.fileManager', [
            'successMessage' => $successMessage,
            'errorMessage' => $errorMessage,
            'folderPathNow' => $folderPathNow,
            'directoryContents' => $filteredContents,
            'selectedFolder' => $selectedFolder,
            'folderContents' => $filesWithPermission ?? [],
            'selectedSubFolder' => $selectedSubFolder,
            'folderPathSesion' => $folderPathSesion,
            'subFolderContents' => $filesSubFolderWithPermission ?? [],
            'freeSpace' => $freeSpaceFormatted,
            'usedSpace' => $usedSpaceFormatted,
            'unformatFilesCount' => $unformatFilesCount,
            'unformatFilesSize' => $formattedUnformatSize,
            'videoFileCount' => $videoFileCount,
            'totalVideoFileSize' => $formattedTotalVideoFileSize,
            'imageFileCount' => $imageFileCount,
            'totalImageFileSize' => $formattedTotalImageFileSize,
            'sqlFileCount' => $sqlFileCount,
            'totalSqlFileSize' => $formattedTotalSqlFileSize,
            'jsFileCount' => $jsFileCount,
            'totalJsFileSize' => $formattedTotalJsFileSize,
            'cssFileCount' => $cssFileCount,
            'totalCssFileSize' => $formattedTotalCssFileSize,
            'htmlFileCount' => $htmlFileCount,
            'totalHtmlFileSize' => $formattedTotalHtmlFileSize,
            'phpFileCount' => $phpFileCount,
            'totalPhpFileSize' => $formattedTotalPhpFileSize,
            'dataSizeFile' => $dataSizeFile,
        ]);
    }
    private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
    
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    private function getGroupName($groupId) {
        if (function_exists('posix_getgrgid')) {
            $groupData = posix_getgrgid($groupId);
            if ($groupData) {
                return $groupData['name'];
            }
        }
        return 'Unknown';
    }
    private function getGroupUsers($group) {
        $command = "getent group $group | cut -d ':' -f 4";
        $users = shell_exec($command);
        $userList = explode(',', trim($users));
    
        return $userList;
    }
    private function countFilesAndExtensions(
        $directory,
        &$unformatExtensions, &$unformatFilesCount, &$totalUnformatSize, 
        &$videoExtension, &$videoFileCount, &$totalVideoFileSize, 
        &$imageExtension, &$imageFileCount, &$totalImageFileSize,
        &$sqlExtension, &$sqlFileCount, &$totalSqlFileSize,
        &$jsExtension, &$jsFileCount, &$totalJsFileSize,
        &$cssExtension, &$cssFileCount, &$totalCssFileSize,
        &$htmlExtension, &$htmlFileCount, &$totalHtmlFileSize,
        &$phpExtension, &$phpFileCount, &$totalPhpFileSize
    )
    {
        $contents = scandir($directory);
        foreach ($contents as $item) {
            if ($item !== '.' && $item !== '..') {
                $path = $directory . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    $this->countFilesAndExtensions(
                        $path,
                        $unformatExtensions, $unformatFilesCount, $totalUnformatSize, 
                        $videoExtension, $videoFileCount, $totalVideoFileSize,
                        $imageExtension, $imageFileCount, $totalImageFileSize,
                        $sqlExtension, $sqlFileCount, $totalSqlFileSize,
                        $jsExtension, $jsFileCount, $totalJsFileSize,
                        $cssExtension, $cssFileCount, $totalCssFileSize,
                        $htmlExtension, $htmlFileCount, $totalHtmlFileSize,
                        $phpExtension, $phpFileCount, $totalPhpFileSize
                    );
                } else {
                    $extension = pathinfo($item, PATHINFO_EXTENSION);
                    $fileSize = filesize($path);
                    if (!in_array($extension, ['bck', 'backup', 'md'], true)) {
                        if (!isset($extensionsCount[$extension])) {
                            $extensionsCount[$extension] = 0;
                        }
                        $extensionsCount[$extension]++;
                        if ($extension === 'php') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $phpExtension[] = $extension;
                                $phpFileCount++;
                                $totalPhpFileSize += $fileSize;
                            }
                        } elseif ($extension === 'js') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $jsExtension[] = $extension;
                                $jsFileCount++;
                                $totalJsFileSize += $fileSize;
                            }
                        } elseif ($extension === 'html') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $htmlExtension[] = $extension;
                                $htmlFileCount++;
                                $totalHtmlFileSize += $fileSize;
                            }
                        } elseif ($extension === 'css') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $cssExtension[] = $extension;
                                $cssFileCount++;
                                $totalCssFileSize += $fileSize;
                            }
                        } elseif ($extension === 'sql') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $sqlExtension[] = $extension;
                                $sqlFileCount++;
                                $totalSqlFileSize += $fileSize;
                            }
                        } elseif ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png' || $extension === 'gif' || $extension === 'svg' || $extension === 'webp') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $imageExtension[] = $extension;
                                $imageFileCount++;
                                $totalImageFileSize += $fileSize;
                            }
                        } elseif ($extension === 'mp4' || $extension === 'avi' || $extension === 'mov' || $extension === 'ogg' || $extension === 'wmv' || $extension === 'webm') {
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $videoExtension[] = $extension;
                                $videoFileCount++;
                                $totalVideoFileSize += $fileSize;
                            }
                        }
                        else {
                            # code...
                            if (!in_array($extension, $unformatExtensions, true)) {
                                $unformatExtensions[] = $extension;
                                $unformatFilesCount++;
                                $totalUnformatSize += $fileSize;
                            }
                        }
                    }
                }
            }
        }
    }
    public function downloadFile(Request $request)
    {
        $itemDownloads = $request->input('fileDownloads');
        $folderItem = session('folderPath');
        $linkDownloadButton     = $folderItem . '/' . $itemDownloads;
        $downloadedFile = $linkDownloadButton;
        $response = response()->download($downloadedFile);
        return $response;
    }
    public function renameFiFo(Request $request)
    {
        $namaBaru = $request->input('namaBaru');
        $namaLama = $request->input('namaLama');
        $folderPath = $request->input('folderPath');
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "renameFiFo";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'namaBaru' => $namaBaru,
            'namaLama' => $namaLama,
            'folderPath' => $folderPath,
        ];
        $postDataJson = json_encode($postData);
        $ch = curl_init();
        $url = env('URL_API') . '/' . $urlEndPoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        // dd($url);
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
            $folderPath = $data[0]->payload->datas->data;
            session(['folderPath' => $folderPath]);
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses  = $data[0]->payload->datas->pesan;
            $message      = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            if ($statusProses) {
                Session::flash('success', $message);
                //Hapus session flash dari failed
                Session::forget('failed');
            } else {
                Session::flash('failed', $message);
                //Hapus session flash dari success
                Session::forget('success');
            }
            // return Redirect::route('singkuasa.fileManager', ['folderItem' => $folderPath])->header('Refresh', '3');
            return redirect()->route("singkuasa.fileManager");
        } else {
            return view("welcome");
        }
    }
    public function fileEditor(Request $request)
    {
        $filePath = $request->input("filePath");
        $pathInfo = pathinfo($filePath);
        $ekstensiFile = $pathInfo['extension'];
        $cleanedFilePath = realpath($filePath);
        $dirName = pathinfo($cleanedFilePath, PATHINFO_DIRNAME);
        $baseName    = $pathInfo['basename'];
        $fileContent = $dirName . '/' . $baseName;
        $content = file_get_contents($fileContent);
        $contentJson = response()->json(['content' => $content]);
        $isiFile = $contentJson->original['content'];
        // dd($isiFile);
        return view("admin.fileEditor")->with('content', $isiFile)->with('fileName', $fileContent)->with('ekstensi', $ekstensiFile);
    }
    public function saveFileEditor(Request $request)
    {
        $namaFile = $request->input('namaFile');
        $content = $request->input('content');
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "editFile";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'namaFile' => $namaFile,
            'content' => $content,
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status = $statusProses ? 'sukses' : 'gagal';
            
            return redirect()->back()->with([
                'sukses' => $status,
                'message' => $message,
            ]);
            
        } else {
            return view("welcome");
        }        
    }
    public function deleteFiFo(Request $request)
    {
        $targetFiFo = $request->input('targetFiFo');
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "deleteFiFo";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'targetFiFo' => $targetFiFo,
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status = $statusProses ? 'sukses' : 'gagal';
            
            return redirect()->back()->with([
                'sukses' => $status,
                'message' => $message,
            ]);
            
        } else {
            return view("welcome");
        }        
    }
    public function createNewFolder(Request $request)
    {
        $pathFo = $request->input('pathFo');
        $namaNewFolder = $request->input('namaNewFolder');
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "createNewFolder";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'namaNewFolder' => $namaNewFolder,
            'pathFo' => $pathFo,
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status = $statusProses ? 'sukses' : 'gagal';
            
            return redirect()->back()->with([
                'sukses' => $status,
                'message' => $message,
            ]);
            
        } else {
            return view("welcome");
        }        
    }
    public function createNewFile(Request $request)
    {
        $pathFi = $request->input('pathFi');
        $namaNewFile = $request->input('namaNewFile');
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "createNewFile";
        $postData = [
            'passwordSudo' => $passwordSudo,
            'namaNewFile' => $namaNewFile,
            'pathFi' => $pathFi,
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
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
            
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status = $statusProses ? 'sukses' : 'gagal';
            
            return redirect()->back()->with([
                'sukses' => $status,
                'message' => $message,
            ]);
            
        } else {
            return view("welcome");
        }        
    }
    public function upNewFile(Request $request)
    {
        $pathFile = $request->input('pathFile');
        $uploadedFile = $request->file('dataFile');
        $passwordSudo = env('SERVER_PASSWORD_SUDO');
        $urlEndPoint = "upNewFile";
    
        $postData = [
            'passwordSudo' => $passwordSudo,
            'pathFile' => $pathFile,
            'uploadedFile' => new \CURLFile($uploadedFile->getRealPath(), $uploadedFile->getClientMimeType(), $uploadedFile->getClientOriginalName()),
        ];
    
        $ch = curl_init();
        $url = env('URL_API') . '/' . $urlEndPoint . '/?api-key=' . env('PUBLIC_API_KEY') . '&token=' . env('USER_TOKEN_API');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Set appropriate headers for sending multipart/form-data
        $headers = [
            // 'Content-Type: application/json',
            'Authorization: Bearer ' . env('USER_TOKEN_API'),
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        // dd($data);
        if ($data != null) {
            $statusProses = $data[0]->payload->datas->status;
            $pesanProses = $data[0]->payload->datas->pesan;
    
            $message = $statusProses ? 'Proses berhasil! ' . $pesanProses : 'Proses Gagal! ' . $pesanProses;
            $status = $statusProses ? 'sukses' : 'gagal';
    
            return redirect()->back()->with([
                'sukses' => $status,
                'message' => $message,
            ]);
        } else {
            return view("welcome");
        }
    }
    public function playVideo(Request $request)
    {
        $filePath = $request->input("filePath");
        $pathInfo = pathinfo($filePath);
        $ekstensiFile = $pathInfo['extension'];
        $cleanedFilePath = realpath($filePath);
        $dirName = pathinfo($cleanedFilePath, PATHINFO_DIRNAME);
        $baseName    = $pathInfo['basename'];
        $fileContent = $dirName . '/' . $baseName;
        $arrayExplode = explode('/', $fileContent);
        $targetWord = "public_html";
        $jumlahKemunculan = 0;

        $publicHtmlIndex = array_search("public_html", $arrayExplode);

        
        foreach ($arrayExplode as $elemen) {
            if ($elemen === $targetWord) {
                $jumlahKemunculan++;
            }
        }

        if ($jumlahKemunculan === 1) {
            if ($publicHtmlIndex !== false && $publicHtmlIndex + 1 < count($arrayExplode)) {
                $remainingParts = array_slice($arrayExplode, $publicHtmlIndex + 1);
                $desiredPath = implode('/', $remainingParts);
                echo $desiredPath;
            } else {
                $desiredPath = null;
            }
            $domain = $arrayExplode[3];
        } else {
            if ($publicHtmlIndex !== false && $publicHtmlIndex + 2 < count($arrayExplode)) {
                $remainingParts = array_slice($arrayExplode, $publicHtmlIndex + 3);
                $desiredPath = implode('/', $remainingParts);
                echo $desiredPath;
            } else {
                $desiredPath = null;
            }
            $domain = $arrayExplode[5];
        }
        if ($desiredPath !== null) {
            # code...
            $link     = 'https://' . $domain.'/'.$desiredPath;
            return view("admin.videoPlayer")->with('fileName', $fileContent)->with('ekstensi', $ekstensiFile)->with('link', $link)->with('desiredPath', $desiredPath);
        } else {
            # code...
            return view("welcome");
        }
        
    }
    public function saveVideo(Request $request)
    {
        // dd($request->input());
        $itemDownloads = $request->input('namaFile');
        $response = response()->download($itemDownloads);
        return $response;
    }
    
}
