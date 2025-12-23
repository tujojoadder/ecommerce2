<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function fieldSetting()
    {
        $pageTitle = "Field Manager";
        return view('admin.settings.field-manager', compact('pageTitle'));
    }
}
