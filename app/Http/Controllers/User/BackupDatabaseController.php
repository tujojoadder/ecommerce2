<?php

namespace App\Http\Controllers\User;

use App\Helpers\GoogleDriveHelper;
use App\Http\Controllers\Controller;
use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;

class BackupDatabaseController extends Controller
{
    public function download()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $backupPath = storage_path('app/public/backups');
        $fileName = $database . '_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupPath . '/' . $fileName;

        // Ensure backup path exists
        if (!Storage::exists($backupPath)) {
            Storage::makeDirectory($backupPath);
        }

        // Create the mysqldump process
        $process = new Process([
            'mysqldump',
            '--user=' . $username,
            '--password=' . $password,
            '--host=' . $host,
            $database,
            '--result-file=' . $filePath,
        ]);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => 'The backup process has failed.', 'message' => $exception->getMessage()], 500);
        }

        try {
            GoogleDriveHelper::uploadToGoogleDrive($filePath, $fileName);

            BackupLog::create([
                'file' => $fileName,
            ]);
            toastr()->success("Database successfully backup!");
            return redirect()->route('user.settings.backup.log');
        } catch (\Throwable $th) {
            return redirect()->route('user.start.google.auth');
        }
    }

    public function downloadLocally()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $backupPath = storage_path('app/public/backups');
        $fileName = $database . '_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupPath . '/' . $fileName;

        // Ensure backup path exists
        if (!Storage::exists($backupPath)) {
            Storage::makeDirectory($backupPath);
        }

        // Create the mysqldump process
        $process = new Process([
            'mysqldump',
            '--user=' . $username,
            '--password=' . $password,
            '--host=' . $host,
            $database,
            '--result-file=' . $filePath,
        ]);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => 'The backup process has failed.', 'message' => $exception->getMessage()], 500);
        }

        // Check if the file already exists in the log
        $existingLog = BackupLog::where('file', $fileName)->first();

        if (!$existingLog) {
            BackupLog::create([
                'file' => $fileName,
            ]);
        }

        toastr()->success("Database successfully backup!");
        // return response()->download($filePath)->deleteFileAfterSend(true);
        return redirect()->route('user.settings.backup.log')->with('download', $filePath);
    }


    public function startGoogleDriveAuth()
    {
        $client = GoogleDriveHelper::getClient();
        $authUrl = $client->createAuthUrl();

        return redirect()->away($authUrl);
    }

    public function handleOAuth2Callback(Request $request)
    {
        $client = GoogleDriveHelper::getClient();

        if ($request->has('code')) {
            $accessToken = $client->fetchAccessTokenWithAuthCode($request->input('code'));

            if (isset($accessToken['error'])) {
                toastr()->error('Failed to authenticate with Google Drive: ' . $accessToken['error']);
                return redirect()->route('start.google.auth');
            }

            // Set the access token and save it
            $client->setAccessToken($accessToken);
            $tokenPath = storage_path('app/token.json');

            // Ensure the directory exists
            File::ensureDirectoryExists(dirname($tokenPath));
            File::put($tokenPath, json_encode($client->getAccessToken()));

            toastr()->success('Google Drive authenticated successfully!');
            return redirect()->route('user.settings.backup.log');
        }

        toastr()->error('Failed to authenticate with Google Drive.');
        return redirect()->route('user.start.google.auth');
    }

    public function getPermissionToDriveBackup()
    {
        $baseURL = config('app.api_base_path');
        $api_key = softwareStatus()->key;
        $url = $baseURL . "/api/package/" . $api_key . "?domain=" . env('APP_URL');
        return redirect($url);
    }
}
