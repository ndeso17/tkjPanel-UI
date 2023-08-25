<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $folderContents = [];

        if ($selectedFolder) {
            $folderPath = "$rootDirectory/$selectedFolder";
            $folderContents = scandir($folderPath);
            $folderContents = array_filter($folderContents, function ($item) {
                return $item !== '.' && $item !== '..';
            });
            
            $filesWithPermission = [];
            
            foreach ($folderContents as $item) {
                $filePath = "$folderPath/$item";
                $permission = substr(sprintf('%o', fileperms($filePath)), -4);
                $createdAt = date("M j, Y H:i:s", filectime($filePath));
                $updatedAt = date("M j, Y H:i:s", filemtime($filePath));
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
        }
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
        return view('admin.fileManager', [
            'directoryContents' => $filteredContents,
            'selectedFolder' => $selectedFolder,
            'folderContents' => $filesWithPermission ?? [],
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

}
