<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'stripe_enabled' => Setting::get('stripe_enabled', '0'),
            'stripe_key' => Setting::get('stripe_key', ''),
            'stripe_secret' => Setting::get('stripe_secret', ''),
            'stripe_webhook_secret' => Setting::get('stripe_webhook_secret', ''),
            'cod_enabled' => Setting::get('cod_enabled', '0'),
            'company_name' => Setting::get('company_name', 'Hawk Prints'),
            'company_email' => Setting::get('company_email', 'info@hawkprints.ca'),
            'company_phone' => Setting::get('company_phone', '905-744-0013'),
            'company_address' => Setting::get('company_address', ''),
            'tax_rate' => Setting::get('tax_rate', '13'),
            'shipping_cost' => Setting::get('shipping_cost', '0'),
            'logo' => Setting::get('logo', ''),
            'favicon' => Setting::get('favicon', ''),
            'seo_title' => Setting::get('seo_title', ''),
            'seo_description' => Setting::get('seo_description', ''),
            'seo_keywords' => Setting::get('seo_keywords', ''),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $booleanSettings = ['stripe_enabled', 'cod_enabled'];
        
        $allSettings = [
            'stripe_enabled', 'stripe_key', 'stripe_secret', 'stripe_webhook_secret', 'cod_enabled',
            'company_name', 'company_email', 'company_phone', 'company_address',
            'tax_rate', 'shipping_cost', 'logo', 'favicon',
            'seo_title', 'seo_description', 'seo_keywords',
        ];
        
        foreach ($allSettings as $setting) {
            if (in_array($setting, $booleanSettings)) {
                $value = $request->has($setting) ? '1' : '0';
            } elseif (in_array($setting, ['logo', 'favicon'])) {
                if ($request->input($setting . '_url')) {
                    $value = $request->input($setting . '_url');
                } else {
                    $value = Setting::get($setting, '');
                }
            } else {
                $value = $request->input($setting, '');
            }
            Setting::set($setting, $value);
        }
        
        return back()->with('success', 'Settings saved successfully!');
    }
}
