<?php

use App\Media;
use App\Order;
use App\OrderActivity;
use App\Theme;
use App\WebSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

// Helper function to handle file uploads
if (! function_exists('uploadFile')) {
    function uploadFile($file, $width = null, $height = null, $subPath = null)
    {
        if (! $file) {
            return null;
        }

        // 📁 Folder
        $baseFolder = 'uploads';
        $folder = $subPath
            ? $baseFolder . '/' . trim($subPath, '/')
            : $baseFolder;

        $destinationPath = public_path($folder);

        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // 🆔 File info
        $uniq_id = uniqid();
        $org_file_name = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        // 📄 Filename (WEBP always)
        $suffix = ($width && $height) ? "_{$width}x{$height}" : '';
        $file_name = $uniq_id . $suffix . '.webp';

        // 🖼 Image processing
        $img = Image::make($file->getRealPath());

        // 🔁 Resize ONLY if width & height provided
        if ($width && $height) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // 🔥 Convert to WEBP (size reduce)
        $img->encode('webp', 80)
            ->save($destinationPath . '/' . $file_name);

        // 🌐 URL
        $url = $folder . '/' . $file_name;

        // 💾 DB Save
        $media = Media::create([
            'type' => 1,
            'file_original_name' => $org_file_name,
            'file_url' => $url,
            'user_id' => Auth::guard('admin')->check()
                ? Auth::guard('admin')->user()->id
                : Auth::guard('manager')->user()->id,
        ]);

        return $media->id;
    }
}

if (! function_exists('uploadSummerNoteFile')) {
    function uploadSummerNoteFile($file, $width, $height, $subPath = null)
    {
        if (! $file) {
            return null;
        }
        // 🔥 uploads is default, subPath optional
        $baseFolder = 'uploads';
        $folder = $subPath
            ? $baseFolder . '/' . trim($subPath, '/')
            : $baseFolder;

        $destinationPath = public_path($folder);

        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $uniq_id = uniqid();
        $file_name = $uniq_id . '_' . $width . 'x' . $height . '.webp';
        $img = Image::make($file->getRealPath());
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath . '/' . $file_name);

        $url = $folder . '/' . $file_name;

        return $url;
    }
}

// Helper function to handle multiple file uploads
if (! function_exists('uploadMultipleFile')) {
    function uploadMultipleFile($files, $width, $height, $subPath = null)
    {
        if (! $files) {
            return null;
        }

        $baseFolder = 'uploads';
        $folder = $subPath
            ? $baseFolder . '/' . trim($subPath, '/')
            : $baseFolder;

        $destinationPath = public_path($folder);

        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $ids = [];

        foreach ($files as $file) {

            $uniq_id = uniqid();
            $org_file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file_name = $uniq_id . '_' . $width . 'x' . $height . '.webp';

            $img = Image::make($file->getRealPath());
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationPath . '/' . $file_name);

            $url = $folder . '/' . $file_name;

            $media = Media::create([
                'type' => 1,
                'file_original_name' => $org_file_name,
                'file_url' => $url,
                'user_id' => Auth::guard('admin')->check()
                    ? Auth::guard('admin')->user()->id
                    : Auth::guard('manager')->user()->id,
            ]);

            $ids[] = $media->id;
        }

        return implode(',', $ids);
    }
}


// Helper function to delete a file
if (! function_exists('deleteFile')) {
    function deleteFile($file_id)
    {
        if ($file_id) {
            $file = Media::find($file_id);
            if ($file) {
                $file_path = public_path($file->file_url);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $file->delete();
            }
        }

        return null;
    }
}
// Helper function to delete multiple files

if (! function_exists('deleteMultipleFiles')) {
    function deleteMultipleFiles($file_ids)
    {
        if ($file_ids) {
            $ids = explode(',', $file_ids);
            foreach ($ids as $id) {
                deleteFile($id);
            }
        }

        return null;
    }
}

// Helper function to handle number formatting like removing commas and converting to float like 1,000.00 to 1000.00
if (! function_exists('formatNumber')) {
    function formatNumber($number)
    {
        if ($number !== null && $number !== '') {
            $number = str_replace(',', '', $number);
            $number = preg_replace('/[^0-9.]/', '', $number);
            $number = (float) $number;

            return number_format($number, 2, '.', '');
        }

        return number_format(0, 2, '.', '');
    }
}

if (! function_exists('order_activities')) {
    function order_activities($data)
    {
        OrderActivity::create([
            'order_id' => $data['order_id'],
            'user_type' => $data['user_type'],
            'created_by' => $data['created_by'],
            'text' => $data['text'],
            'comment' => $data['comment'] ?? null,
            'activity_type' => $data['activity_type'],
            'new_order' => $data['new_order'] ?? null,
            'old_order' => $data['old_order'] ?? null,
        ]);
    }
}

if (! function_exists('invoice_generate')) {
    function invoice_generate()
    {
        $settings = WebSettings::first();
        $prefix = $settings->invoice_prefix ?? 'INV';

        // lockForUpdate() দেওয়া আছে, কিন্তু এর লকটি বজায় থাকবে মূল কন্ট্রোলারের ট্রানজেকশন শেষ হওয়া পর্যন্ত
        $lastOrder = Order::withTrashed()
            ->latest('id')
            ->select('invoice_id')
            ->lockForUpdate()
            ->first();
        // dd($lastOrder);

        if ($lastOrder && $lastOrder->invoice_id) {
            preg_match('/(\d+)$/', $lastOrder->invoice_id, $matches);
            $lastNumber = isset($matches[1]) ? (int)$matches[1] : 0;
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $invoice_id = $prefix . $nextNumber;

        while (Order::where('invoice_id', $invoice_id)->exists()) {
            $nextNumber++;
            $invoice_id = $prefix . $nextNumber;
        }

        return $invoice_id;
    }
}

// Common theme controller handler
function activeThemeController(Request $request, $theme, $method, ...$params)
{
    if (! $theme) {
        abort(404, 'Theme not found.');
    }

    // 🔐 DEMO MODE GLOBAL PROTECTION
    if (isDemo()->is_demo == 1 && Auth::guard('admin')->check() && Auth::guard('admin')->user()->role_id != 1) {
        $assignedTheme = Auth::guard('admin')->user()->get_theme;

        if ($assignedTheme && $assignedTheme->id !== $theme->id) {
            return redirect()->route('theme.home', [
                'path' => $assignedTheme->path
            ]);
        }
    }
    // 🎯 Controller resolve
    $controllerClass =
        '\\App\\Http\\Controllers\\Theme\\' .
        str_replace(' ', '', ucwords(str_replace('-', ' ', $theme->path))) .
        'Controller';

    if (! class_exists($controllerClass)) {
        abort(404, "Controller not found for theme: {$theme->path}");
    }
    $controller = app()->make($controllerClass);

    if (! method_exists($controller, $method)) {
        abort(404, "Method {$method} not found.");
    }

    return $controller->{$method}($request, $theme, ...$params);
}

//  Helper: Active theme getter
if (! function_exists('activeTheme')) {
    function activeTheme()
    {
        return Theme::where('is_active', 1)
            ->select('id', 'path', 'is_active')
            ->first();
    }
}
if (! function_exists('activeThemeData')) {
    function activeThemeData()
    {
        $settings = WebSettings::select('is_demo')->first();
        if (
            $settings->is_demo == 1 &&
            Auth::guard('admin')->check() &&
            Auth::guard('admin')->user()->theme_id &&
            Auth::guard('admin')->user()->role_id != 1
        ) {
            return Auth::guard('admin')->user()->get_theme;
        }
        return Theme::where('is_active', 1)->first();
    }
}
// is demo check
if (! function_exists('isDemo')) {
    function isDemo()
    {
        return WebSettings::select('is_demo')->first();
    }
}
