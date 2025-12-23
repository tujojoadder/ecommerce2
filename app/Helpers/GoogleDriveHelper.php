<?php

namespace App\Helpers;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\File;

class GoogleDriveHelper
{
    public static function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->setRedirectUri(env('APP_URL') . 'user/oauth2callback');
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        $tokenPath = storage_path('app/token.json');
        if (File::exists($tokenPath)) {
            $accessToken = json_decode(File::get($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()) {
            // Refresh the token using the refresh token if available
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN)); // Enter the code from the URL

                // Exchange authorization code for an access token
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Save the token to a file
                if (!File::exists(dirname($tokenPath))) {
                    File::makeDirectory(dirname($tokenPath), 0700, true);
                }
                File::put($tokenPath, json_encode($client->getAccessToken())); // Save the access token
            }
        }

        return $client;
    }

    public static function uploadToGoogleDrive($filePath, $fileName)
    {
        $client = self::getClient();

        // Refresh the token if it's expired
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                return redirect($client->createAuthUrl()); // Redirect to Google OAuth page
            }
        }

        $service = new Google_Service_Drive($client);

        // Prepare the file metadata and content
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [siteSettings()->google_drive_folder_id] // Replace with your folder ID
        ]);
        $content = file_get_contents($filePath);

        // Upload the file to Google Drive
        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/sql',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $file->id;
    }
}
