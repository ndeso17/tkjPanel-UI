<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\fileManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('singkuasa')->group(function () {
    Route::get('/', [UserViewController::class, 'index'])
        ->name("singkuasa.index");
    Route::get('domain', [UserViewController::class, 'allDomainAndNameserver'])
        ->name("singkuasa.domain");
    Route::get('domain/{domain}', [UserViewController::class, 'domainRecordManager'])
        ->name('singkuasa.domainRecordManager');    
    Route::put('deleteRecordDomain', [UserViewController::class, 'deleteRecordDomain'])
        ->name("singkuasa.deleteRecordDomain");
    Route::post('addRecordDomain', [UserViewController::class, 'addRecordDomain'])
        ->name("singkuasa.addRecordDomain");
    Route::post('createNewDomain', [UserViewController::class, 'createNewDomain'])
        ->name("singkuasa.createNewDomain");
    Route::put('deleteDomain', [UserViewController::class, 'deleteDomain'])
        ->name("singkuasa.deleteDomain");
    Route::get('listFtpClient', [UserViewController::class, 'listFtpClient'])
        ->name("singkuasa.listFtpClient");
    Route::post('addFtpClient', [UserViewController::class, 'addFtpClient'])
        ->name("singkuasa.addFtpClient");
    Route::put('deleteFtpClient', [UserViewController::class, 'deleteFtpClient'])
        ->name("singkuasa.deleteFtpClient");
    Route::get('setupApp', [UserViewController::class, 'setupApp'])
        ->name("singkuasa.setupApp");
    Route::get('database', [UserViewController::class, 'getAllDatabase'])
        ->name("singkuasa.getAllDatabase");
    Route::post('createUserMysql', [UserViewController::class, 'createUserMysql'])
        ->name("singkuasa.createUserMysql");
    Route::post('createNewDatabase', [UserViewController::class, 'createNewDatabase'])
        ->name("singkuasa.createNewDatabase");
    Route::get('nameserver', [UserViewController::class, 'nameserver'])
        ->name("singkuasa.nameserver");
    Route::post('addNewNameserver', [UserViewController::class, 'addNewNameserver'])
        ->name("singkuasa.addNewNameserver");
    Route::get('fileManager', [fileManagerController::class, 'fileManager'])
        ->name("singkuasa.fileManager");
    Route::post('fileManager', [fileManagerController::class, 'fileManager'])
        ->name("singkuasa.fileManager");
    Route::post('downloadFile', [fileManagerController::class, 'downloadFile'])
        ->name("singkuasa.downloadFile");
    Route::post('renameFiFo', [fileManagerController::class, 'renameFiFo'])
        ->name("singkuasa.renameFiFo");
    Route::get('fileEditor', [fileManagerController::class, 'fileEditor'])
        ->name("singkuasa.fileEditor");
    Route::post('saveFileEditor', [fileManagerController::class, 'saveFileEditor'])
        ->name("singkuasa.saveFileEditor");
    Route::post('deleteFiFo', [fileManagerController::class, 'deleteFiFo'])
        ->name("singkuasa.deleteFiFo");
    Route::post('upNewFile', [fileManagerController::class, 'upNewFile'])
        ->name("singkuasa.upNewFile");
    Route::post('createNewFolder', [fileManagerController::class, 'createNewFolder'])
        ->name("singkuasa.createNewFolder");
    Route::post('createNewFile', [fileManagerController::class, 'createNewFile'])
        ->name("singkuasa.createNewFile");
    Route::post('playVideo', [fileManagerController::class, 'playVideo'])
        ->name("singkuasa.playVideo");
    Route::post('saveVideo', [fileManagerController::class, 'saveVideo'])
        ->name("singkuasa.saveVideo");
});