<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ColorSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        $pageTitle = __('messages.settings');
        $credentialsPath = storage_path('app/credentials.json');
        $credentials = File::exists($credentialsPath) ? File::get($credentialsPath) : '';
        return view('user.settings.index', compact('pageTitle', 'credentials'));
    }

    public function updateCredentials(Request $request)
    {
        $credentials = $request->input('credentials'); // Retrieve JSON input directly
        try {
            File::put(storage_path('app/credentials.json'), $credentials);
            toastr()->success('Credentials updated successfully!');
            return response()->json(['message' => 'Credentials updated successfully']);
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return response()->json(['message' => 'Failed to update credentials'], 500);
        }
    }

    public function language()
    {
        try {
            DB::beginTransaction();

            $lang = request()->lang;
            $setting = SiteSetting::first();
            $setting->language = $lang;
            $setting->save();

            // set locale
            App::setLocale(request()->lang);
            session()->put('locale', request()->lang);

            DB::commit();

            toastr()->info('Language changed!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
    public function menuSizes()
    {
        $size = request()->size;
        $setting = SiteSetting::first();
        $setting->menu_size = $size;
        $setting->save();
        toastr()->info('Menu size changed!');
        return redirect()->back();
    }
    public function pageLength()
    {
        $length = request()->page_length;
        $setting = SiteSetting::first();
        $setting->page_length = $length;
        $setting->save();
        toastr()->info('Page Length changed!');
        return redirect()->back();
    }
    public function updateColors()
    {
        ColorSetting::first()->update(request()->except('_token', '_method'));
        return response()->json(['message' => 'Colors updated successfully']);
    }
    public function updateSmsFormat()
    {
        $setting = SiteSetting::first();
        $setting->receive_sms = nl2br(request()->receive_sms);
        $setting->invoice_sms = nl2br(request()->invoice_sms);

        $setting->api_key = request()->api_key;
        $setting->api_url = request()->api_url;
        $setting->sender_id = request()->sender_id;

        $setting->save();
        return response()->json(['message' => 'SMS Format updated successfully']);
    }

    public function checkSmsBalance()
    {
        $apiBasePath = config('app.api_base_path');
        $apiKey = softwareStatus()->key;

        $url = "{$apiBasePath}/recharge/check/balance";
        $queryParams = ['ca_key' => $apiKey];
        $fullUrl = $url . '?' . http_build_query($queryParams);
        $ch = curl_init($fullUrl); // Initialize curl session
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set curl options
        $response = curl_exec($ch); // Execute curl session and get the response
        // Check for curl errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch); // Handle error appropriately
        }
        curl_close($ch); // Close curl session

        // Get balance from api response
        $apiResponse = $response;
        $responseData = json_decode($apiResponse, true);
        $balance = $responseData['balance'];

        return response()->json($balance);
    }

    public function resetColor()
    {
        ColorSetting::first()->update([
            'layout_gradient_left' => '#f54266',
            'layout_gradient_right' => '#3858f9',
            'sidebar_bg_color_left' => '#ffffff',
            'sidebar_bg_color_right' => '#ffffff',
            'sidebar_menu_hover_color' => '#3858f9',
            'sidebar_text_color' => '#000000',
            'card_border_color' => '#87ceeb',
            'card_header_color' => '#ffffff',
            'card_body_color' => '#ffffff',
            'card_text_color' => '#000000',
            'label_color' => '#000000',
            'input_bg_color' => '#ffffff',
            'input_color' => '#000000',
            'table_header_bg_color' => '#919191',
            'table_header_text_color' => '#ffffff',
            'table_text_color' => '#000000',
            'table_border_color' => '#6e6e6e',
            'success_btn_color' => '#0ba360',
            'danger_btn_color' => '#f53c5b',
            'info_btn_color' => '#17a2b8',
            'warning_btn_color' => '#ffc107',
            'primary_btn_color' => '#3858f9',
            'secondary_btn_color' => '#7987a1',
            'dark_btn_color' => '#212022',
        ]);
        toastr()->success('Color preset restored successfully!');
        return redirect()->back();
    }
}
