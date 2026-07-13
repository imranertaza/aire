<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * API Controller for managing global application settings.
 *
 * Settings are stored in the `settings` table as key-value pairs.
 * Supports updating text values, file uploads (logos, images), and
 * selective modification of .env values for reCAPTCHA configuration.
 */
class SettingsController extends Controller
{
    /**
     * Retrieve all application settings.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::success(Setting::all(), 'Settings retrieved successfully');
    }

    /**
     * Update one or more application settings.
     *
     * Handles text fields, file uploads, and special .env updates
     * for reCAPTCHA-related keys.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Store Info
            'address'             => 'sometimes|string|max:255',
            'email'               => 'sometimes|email|max:155',
            'phone'               => 'sometimes|string|max:50',
            'state'               => 'sometimes|string|max:50',

            // File Uploads
            'store_logo'          => 'sometimes|image|mimes:png,jpg,jpeg,svg,webp|max:4096',
            'store_icon'          => 'sometimes|image|mimes:png,jpg,jpeg,ico,webp|max:2048',
            'footer_logo'         => 'sometimes|image|mimes:png,jpg,jpeg,svg,webp|max:4096',
            'breadcrumb'          => 'sometimes|image|mimes:png,jpg,jpeg,svg,webp|max:4096',
            'og_image'            => 'sometimes|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'twitter_image'       => 'sometimes|image|mimes:png,jpg,jpeg,webp|max:5120',

            // Mail Settings
            'mail_protocol'       => 'sometimes|in:smtp,mail,sendmail',
            'mail_address'        => 'sometimes|email|max:155',
            'send_from'        => 'sometimes|email|max:155',
            'smtp_host'           => 'sometimes|string|max:155',
            'smtp_username'       => 'sometimes|string|max:155',
            'smtp_password'       => 'sometimes|string|max:255',
            'smtp_port'           => 'sometimes|numeric|between:1,65535',
            'smtp_timeout'        => 'sometimes|numeric|between:1,300',
            'smtp_crypto'         => 'sometimes|in:ssl,tls,""',

            // Social Links
            'fb_url'              => 'sometimes|url|max:255',
            'twitter_url'         => 'sometimes|url|max:255',
            'linkedin_url'        => 'sometimes|url|max:255',
            'instagram_url'       => 'sometimes|url|max:255',

            // SEO & Meta
            'meta_title'          => 'sometimes|string|max:155',
            'meta_keyword'        => 'sometimes|string|max:255',
            'meta_description'    => 'sometimes|string|max:500',
            'meta_author'         => 'sometimes|string|max:155',
            'meta_news_keywords'  => 'sometimes|string|max:255',

            // Open Graph
            'og_type'             => 'sometimes|string|max:50',
            'og_title'            => 'sometimes|string|max:255',
            'og_description'      => 'sometimes|string|max:500',
            'og_image_width'      => 'sometimes|numeric',
            'og_image_height'     => 'sometimes|numeric',

            // Twitter Card
            'twitter_card'        => 'sometimes|string|max:50',
            'twitter_title'       => 'sometimes|string|max:255',
            'twitter_description' => 'sometimes|string|max:500',
            'twitter_domain'      => 'sometimes|url|max:255',

            // Brand
            'brand_name'          => 'sometimes|string|max:255',

            // reCAPTCHA (these will update .env)
            'use_recaptcha'       => 'sometimes|in:0,1',
            'nocaptcha_sitekey'   => 'sometimes|string|max:255',
            'nocaptcha_secret'    => 'sometimes|string|max:255',
        ]);

        $removableImages = [
            'remove_store_logo' => 'store_logo',
            'remove_footer_logo' => 'footer_logo',
            'remove_store_icon' => 'store_icon',
            'remove_breadcrumb' => 'breadcrumb',
            'remove_og_image' => 'og_image',
            'remove_twitter_image' => 'twitter_image',
        ]; // Build rules dynamically
        $rules = [];
        foreach ($removableImages as $removeKey => $fieldName) {
            if ($request->$removeKey == 1) {
                $rules[$fieldName] = 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048';
            }
        }
        $request->validate($rules);

        $updated = [];
        $envKeys = ['use_recaptcha', 'nocaptcha_sitekey', 'nocaptcha_secret'];

        foreach ($validated as $label => $value) {
            if (in_array($label, $envKeys)) {
                $envKey = strtoupper($label);
                $current = env($envKey);

                $normalizedValue = $value === '1' || $value === 1 || $value === true ? 'true' : 'false';

                if ((string) $current !== $normalizedValue && !in_array($label, ['nocaptcha_sitekey', 'nocaptcha_secret'])) {
                    $this->setEnvValue($envKey, $normalizedValue);
                } elseif ($label !== 'use_recaptcha' && $current !== $value) {
                    $this->setEnvValue($envKey, $value);
                }

                $updated[$label] = $value;
                continue;
            }

            $setting = Setting::firstOrCreate(['label' => $label]);

            if ($request->hasFile($label)) {
                $file = $request->file($label);

                // Delete old file
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);

                    // Clean up empty directory
                    $dir = dirname($setting->value);
                    if (empty(Storage::disk('public')->files($dir))) {
                        Storage::disk('public')->deleteDirectory($dir);
                    }
                }

                // Build unique filename and folder path
                $filename = $label . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("settings/{$label}", $filename, 'public');

                $newValue = $path;
            } else {
                $newValue = $value;
            }

            $setting->value     = $newValue;
            $setting->updatedBy = Auth::id() ?? null;
            $setting->save();

            $updated[$label] = $newValue;
        }

        return ApiResponse::success($updated, 'Settings updated successfully');
    }


    /**
     * Update a specific key in the .env file.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    private function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');
        $content = file_get_contents($envPath);

        $pattern = "/^{$key}=.*/m";

        if (preg_match($pattern, $content)) {
            // Replace existing
            $content = preg_replace($pattern, "{$key}={$value}", $content);
        } else {
            // Append new
            $content .= "\n{$key}={$value}";
        }

        file_put_contents($envPath, $content);
    }

    /**
     * Retrieve current reCAPTCHA security settings from config.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecuritySettings()
    {
        return response()->json([
            'use_recaptcha'     => config('services.use_recaptcha'),
            'nocaptcha_sitekey' => config('services.sitekey'),
            'nocaptcha_secret'  => config('services.secret'),
        ]);
    }
}
