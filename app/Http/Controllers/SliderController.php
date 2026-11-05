<?php

namespace App\Http\Controllers;

use App\Media;
use App\Slider;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index()
    {
        $data = Slider::with('get_img')->where('theme_id', activeThemeData()->id)->latest()->get();

        return view('backEnd.admin.sliders.index', compact('data'));
    }

    public function store(Request $request)
    {
        $size = config('slider_size');

        // activeThemeData()->path অ্যারেতে আছে কিনা এবং null নয় কিনা তা চেক করা হচ্ছে
        $themePath = activeThemeData()->path ?? null;

        if ($themePath && isset($size[$themePath])) {
            $width = $size[$themePath]['width'] ?? 1920;
            $height = $size[$themePath]['height'] ?? 800;
        } else {
            $width = 1920;
            $height = 800;
        }
        if ($request->hasFile('slider_image')) {
            $uniq_id = uniqid();
            $destinationPath = public_path('uploads');
            $file1 = $request->file('slider_image');

            $org_file_name1 = $file1->getClientOriginalName();
            $file_name = $uniq_id . '_' . $width . 'x' . $height . '.' . 'webp';

            $img = Image::make($file1->getRealPath());
            $img->resize($width, $height, function (/* $constraint */) {
                /* $constraint->aspectRatio(); */
            })->save($destinationPath . '/' . $file_name, 90);

            $url = 'uploads/' . $file_name;

            $file_id = Media::create([
                'type' => 3,
                'file_original_name' => $org_file_name1,
                'file_url' => $url,
                'user_id' => Auth::guard('admin')->user()->id,
            ]);

            $url = $file_id->id;
        } else {
            return back()->with('error', 'No Image Selected');
        }

        Slider::create([
            'slider_image' => $url,
            'slider_url' => $request->slider_url,
            'theme_id' => activeThemeData()->id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sliders')->with('success', 'Slider Added Successfully');
    }

    public function update(Request $request)
    {
        $size = config('slider_size');
        if ($size[activeThemeData()->path] != null) {
            $size = $size[activeThemeData()->path];
            $width = $size['width'];
            $height = $size['height'];
        } else {
            $width = 1920;
            $height = 800;
        }
        if ($request->hasFile('slider_image')) {
            $uniq_id = uniqid();
            $destinationPath = public_path('uploads');
            $file1 = $request->file('slider_image');

            $org_file_name1 = $file1->getClientOriginalName();
            $file_name = $uniq_id . '_' . $width . 'x' . $height . '.' . 'webp';

            $img = Image::make($file1->getRealPath());
            $img->resize($width, $height, function (/* $constraint */) {
                /* $constraint->aspectRatio(); */
            })->save($destinationPath . '/' . $file_name, 90);

            $url = 'uploads/' . $file_name;

            $file_id = Media::create([
                'type' => 3,
                'file_original_name' => $file_name,
                'file_url' => $url,
                'user_id' => Auth::guard('admin')->user()->id,
            ]);

            $url = $file_id->id;
        } else {
            $url = $request->slider_image_old;
        }

        Slider::find($request->id)->update([
            'slider_image' => $url,
            'slider_url' => $request->slider_url,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sliders')->with('success', 'Slider Added Successfully');
    }
    public function updatePosition(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sliders,id',
            'position' => 'required|integer'
        ]);

        Slider::where('id', $request->id)
            ->where('theme_id', activeThemeData()->id)
            ->update([
                'position' => $request->position
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Position Updated'
        ]);
    }


    public function status(Request $request, $id)
    {

        $status = Slider::findOrFail($id);
        $status->update(['status' => ! $status->status]);

        return back()->with('success', 'Status Updated Successfully');
    }

    public function delete($id)
    {
        Slider::find($id)->delete();

        return back()->with('success', 'Slider Deleted Successfully');
    }

    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:sliders,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            Slider::whereIn('id', $request->ids)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' item(s) deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
