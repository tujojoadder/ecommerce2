<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteManager;
use Illuminate\Http\Request;

class SiteManagerController extends Controller
{
    public function index()
    {
        $pageTitle = "Site Manager";
        $managers = SiteManager::all();
        return view('admin.settings.managers', compact('pageTitle', 'managers'));
    }

    function update(Request $request)
    {
        $managersData = $request->input('managers', []);

        foreach ($managersData as $settingId => $data) {
            $setting = SiteManager::findOrFail($settingId);
            $setting->update([
                'status' => isset($data['status']) && $data['status'] === 'on', // Update status based on checkbox
            ]);
        }

        toast('Site Manager Updated Successfully!', 'success');
        return redirect()->back();
    }
}
