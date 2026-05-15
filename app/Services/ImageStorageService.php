<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageStorageService
{
    public function __construct()
    {
        $this->applyAwsConfig();
    }

    protected function applyAwsConfig()
    {
        $key = Setting::get('aws_access_key_id');
        $secret = Setting::get('aws_secret_access_key');
        $region = Setting::get('aws_default_region');
        $bucket = Setting::get('aws_bucket');
        $url = Setting::get('aws_url');

        if ($key) {
            config(['filesystems.disks.s3.key' => $key]);
        }
        if ($secret) {
            config(['filesystems.disks.s3.secret' => $secret]);
        }
        if ($region) {
            config(['filesystems.disks.s3.region' => $region]);
        }
        if ($bucket) {
            config(['filesystems.disks.s3.bucket' => $bucket]);
        }
        if ($url) {
            config(['filesystems.disks.s3.url' => $url]);
        }
    }

    public function disk(): string
    {
        return Setting::get('image_storage', 'local') === 's3' ? 's3' : 'public';
    }

    public function uploadRaw($file, string $path, string $filename): string
    {
        $disk = $this->disk();
        $fullPath = $path . '/' . $filename;

        if ($disk === 's3') {
            Storage::disk('s3')->put($fullPath, (string) file_get_contents($file));
            return Storage::disk('s3')->url($fullPath);
        }

        $file->storeAs($path, $filename, 'public');
        return '/storage/' . $fullPath;
    }

    public function uploadWithSizes($file, string $filename, array $sizes): array
    {
        $paths = [];
        $disk = $this->disk();

        $paths['image'] = $this->uploadRaw($file, 'products', $filename);

        foreach ($sizes as $key => $width) {
            $img = Image::read($file);
            $img->scale(width: $width);

            if ($disk === 's3') {
                $tempPath = tempnam(sys_get_temp_dir(), 'img_');
                $img->save($tempPath);
                $s3Path = 'products/' . $key . '/' . $filename;
                Storage::disk('s3')->put($s3Path, (string) file_get_contents($tempPath));
                unlink($tempPath);
                $paths[$key] = Storage::disk('s3')->url($s3Path);
            } else {
                $dir = storage_path('app/public/products/' . $key);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                $img->save($dir . '/' . $filename);
                $paths[$key] = '/storage/products/' . $key . '/' . $filename;
            }
        }

        return $paths;
    }

    public function delete(string $url): void
    {
        if (!$url) {
            return;
        }

        // Detect source from URL format
        if (str_starts_with($url, '/storage/')) {
            $storagePath = str_replace('/storage/', '', $url);
            Storage::disk('public')->delete($storagePath);
        } elseif (str_starts_with($url, 'http')) {
            $s3Url = Storage::disk('s3')->url('');
            $path = str_replace($s3Url, '', $url);
            $path = ltrim($path, '/');
            if ($path) {
                Storage::disk('s3')->delete($path);
            }
        }
    }
}
