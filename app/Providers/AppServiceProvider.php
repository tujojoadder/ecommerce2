<?php

namespace App\Providers;

use App\Helpers\Traits\BalanceTrait;
use App\Models\CompanyInformation;
use App\Models\FieldManager;
use App\Models\ShortcutMenu;
use App\Models\SiteManager;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use BalanceTrait;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        try {
            if (!request()->routeIs('login')) {
                $wallet_names = cache()->remember('wallet_name', 3600, function () {
                    return [$this->getWalletNames()];
                });
                foreach ($wallet_names as $value) {
                    config($value);
                }
            }

            // Cache site settings
            $siteSetting = cache()->remember('siteSettings', 3600, function () {
                return siteSettings();
            });

            if ($siteSetting->language == 'en') {
                $siteSetting->language = 'en';
            } else {
                $siteSetting->language = 'bn';
            }
            $siteSetting->save();

            $defaultLocale = $siteSetting->language;
            App::setLocale($defaultLocale);
            session()->put('locale', $defaultLocale);

            initSiteConfig();

            // Cache sidebar access config
            $sidebar = cache()->remember('sidebarConfig', 3600, function () {
                $siteManagers = siteManagers() ?? [];
                $sidebarConfig = [];
                foreach ($siteManagers as $siteManager) {
                    $sidebarConfig[$siteManager->type . '.' . $siteManager->section] = $siteManager->status;
                }
                return $sidebarConfig;
            });
            config($sidebar);

            // sidebar access config end

            // Cache form field access config
            $fields = FieldManager::all() ?? [];
            $fieldsConfig = [];
            foreach ($fields as $value) {
                $fieldsConfig[$value->table_name . '_' . $value->field_name] = $value->status;
            }
            config($fieldsConfig);
            config(['all' => $fields]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
        // form field access config end

    }
}
