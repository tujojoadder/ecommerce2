<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

class InstallerController extends Controller
{
    public function index()
    {
        if (Route::is('install.index')) {
            $pageTitle = 'Database Configuration';
        }
        if (Route::is('install.billing')) {
            $pageTitle = 'Billing Configuration';
        }
        return view('installer.index', compact('pageTitle'));
    }

    public function setDatabaseInfo(Request $request)
    {
        try {
            $this->setDatabase([$request->db_name, $request->db_username, $request->db_password]);
            return redirect()->route('install.billing');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function setBillingInfo(Request $request)
    {
        try {
            $this->setBilling([$request->set_api_key, $request->set_invoice_id]);
            return redirect()->route('install.initial.setup');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function setup()
    {
        try {
            Artisan::call('migrate:fresh');

            Artisan::call('db:seed CompanyInformationSeeder');
            Artisan::call('db:seed SiteSettingsSeeder');
            Artisan::call('db:seed FieldManagerSeeder');
            Artisan::call('db:seed SiteManagerSeeder');
            Artisan::call('db:seed SiteColorSeeder');
            Artisan::call('db:seed SiteKeywordSeeder');

            Artisan::call('db:seed AdminSeeder');
            Artisan::call('db:seed UserSeeder');

            Artisan::call('db:seed RoleSeeder');
            Artisan::call('db:seed PermissionSeeder');
            Artisan::call('db:seed RoleHasPermissionSeeder');
            Artisan::call('db:seed ModelHasRoleSeeder');

            Artisan::call('db:seed SoftwareStatusSeeder');
            Artisan::call('db:seed AccountSeeder');
            $this->storageLink();
            $this->enableProduction();
            $routeFile = base_path('routes/install.php');
            if (file_exists($routeFile)) {
                unlink($routeFile);
                return redirect()->route('login');
            }
            return redirect()->route('login');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storageLink()
    {
        curlRun();
        $linkPath = public_path('storage');
        if (file_exists($linkPath)) {
            unlink($linkPath);
        }
        Artisan::call('optimize:clear');
        return Artisan::call('storage:link');
    }

    function setDatabase($db_info)
    {
        $envFile = base_path('.env');
        $currentEnv = file_get_contents($envFile);
        $db_database = $db_info[0];
        $db_username = $db_info[1];
        $db_password = $db_info[2];
        $appUrl = url()->to('/');
        $assetUrl = $appUrl . '/public';

        $new_env = preg_replace('/DB_DATABASE=(.*)/', 'DB_DATABASE=' . $db_database, $currentEnv);
        $new_env = preg_replace('/DB_USERNAME=(.*)/', 'DB_USERNAME=' . $db_username, $new_env);
        $new_env = preg_replace('/DB_PASSWORD=(.*)/', 'DB_PASSWORD=' . $db_password, $new_env);
        $new_env = preg_replace('/APP_URL=(.*)/', 'APP_URL=' . $appUrl, $new_env);
        $new_env = preg_replace('/ASSET_URL=(.*)/', 'ASSET_URL=' . $assetUrl, $new_env);

        file_put_contents($envFile, $new_env);

        return 0;

        // setDatabaseInfo([request()->db_name, request()->db_username, request()->db_password]); //usage
    }

    function setBilling($billingInfo)
    {
        $seederFile = base_path('database/seeders/SoftwareStatusSeeder.php');
        $currentSeederFile = file_get_contents($seederFile);

        if (!$currentSeederFile) {
            return "Error: Unable to read seeder file.";
        }

        // Create new values
        $new_key = "'key' => '" . $billingInfo[0] . "'";
        $new_invoice_id = "'invoice_id' => '" . $billingInfo[1] . "'";

        // Update key and invoice_id in the file
        $updatedSeederFile = preg_replace(
            ["/'key'\s*=>\s*'([^']+)'/", "/'invoice_id'\s*=>\s*'([^']+)'/"],
            [$new_key, $new_invoice_id],
            $currentSeederFile
        );

        // Write the updated content back to the file
        file_put_contents($seederFile, $updatedSeederFile);

        return true;
    }

    function enableProduction()
    {
        $envFile = base_path('.env');
        $currentEnv = file_get_contents($envFile);
        $APP_DEBUG = 'false';
        $new_env = preg_replace('/APP_ENV=(.*)/', 'APP_ENV=' . 'production', $currentEnv);
        $new_env = preg_replace('/APP_DEBUG=(.*)/', 'APP_DEBUG=' . 'false', $new_env);
        $new_env = preg_replace('/DEBUGBAR_ENABLED=(.*)/', 'DEBUGBAR_ENABLED=' . 'false', $new_env);
        file_put_contents($envFile, $new_env);
        return 0;
    }
}
