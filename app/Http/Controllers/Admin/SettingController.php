<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->get()->groupBy('group');
        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                if ($setting->type == 'file' && $value instanceof \Illuminate\Http\UploadedFile) {
                    // Hapus file lama jika ada
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    
                    // Upload file baru dengan nama yang unik
                    $path = $value->store('settings', 'public');
                    $value = $path;
                }
                
                Setting::set($key, $value);
            }
        }

        // Clear cache setelah update settings
        Cache::forget('website_settings');
        
        // Update config app name
        if ($request->has('site_title')) {
            config(['app.name' => $request->site_title]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
} 