<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function editLogo()
    {
        $logo = Setting::firstWhere('key', 'logo')->value;
        return view('admin.settings.logo', compact('logo'));
    }

    public function updateLogo(Request $req)
    {
        $req->validate([
            'logo' => [
                'required',
                'image',
                'max:2048',
                'dimensions:max_width=500,max_height=500'
            ],
        ], [
            'logo.dimensions' => 'La imagen no debe superar 500×500 px.',
            'logo.max'        => 'El logo no puede pesar más de 2 MB.',
        ]);

        $path = $req->file('logo')->store('settings', 'public');
        Setting::updateOrCreate(['key' => 'logo'], ['value' => $path]);

        return redirect()
            ->route('admin.settings.logo.edit')
            ->with('success', 'Logo actualizado');
    }
}
