<?php

namespace App\Http\Controllers;

use App\Media;
use App\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('position', 'asc')->get();
        return view('backEnd.admin.testimonial.index', compact('testimonials'));
    }
    public function store(Request $request)
    {
        // ১. ভ্যালিডেশনে review এবং rating অ্যাড করা হলো
        $request->validate([
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'review'   => 'nullable|string',
            'rating'   => 'required|integer|between:1,5',
            'position' => 'nullable|integer',
            'status'   => 'nullable|boolean',
        ]);

        $testimonial = new Testimonial();

        // আপনার আগের মেকানিজম অনুযায়ী ইমেজ আপলোড করে আইডি নেওয়া হচ্ছে
        if ($request->hasFile('image')) {
            $testimonial->image = uploadFile($request->file('image'), null, null, 'testimonials');
        }

        $testimonial->review   = $request->review;
        $testimonial->rating   = $request->rating;
        $testimonial->position = $request->position;
        $testimonial->status   = $request->status ?? 0;
        $testimonial->theme_id = activeThemeData()->id; // থিম আইসোলেশন প্রটেকশন
        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // ২. আপডেটের ভ্যালিডেশনেও ফিল্ডগুলো যুক্ত করা হলো
        $request->validate([
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'review'   => 'nullable|string',
            'rating'   => 'required|integer|between:1,5',
            'position' => 'nullable|integer',
            'status'   => 'nullable|boolean',
        ]);

        // আপনার দেওয়া মিডিয়া হ্যান্ডেলিং লজিক ঠিক রাখা হলো
        if ($request->hasFile('image')) {
            $image_id = uploadFile($request->file('image'), null, null, 'testimonials');

            // পুরোনো ইমেজ থাকলে এবং ডিলিট ফাংশনালিটি থাকলে তা ট্রিগার করা
            if ($testimonial->image && function_exists('deleteFile')) {
                deleteFile($testimonial->image);
            }
        } else {
            $image_id = $testimonial->image; // নতুন ইমেজ না দিলে আগের আইডি বহাল থাকবে
        }

        $testimonial->image    = $image_id;
        $testimonial->review   = $request->review;
        $testimonial->rating   = $request->rating;
        $testimonial->position = $request->position;
        $testimonial->status   = $request->status ?? 0;
        $testimonial->save();

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function delete($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // ৩. ডাটাবেজ থেকে ডিলিট করার আগে আপনার শর্তানুযায়ী মিডিয়া ফাইল রিমুভ করা
        if ($testimonial->image) {
            $media = Media::find($testimonial->image);
            if ($media) {
                // যদি ফিজিক্যাল ফাইলও ডিলিট করতে চান
                if (file_exists(public_path($media->file_url))) {
                    @unlink(public_path($media->file_url));
                }
                $media->delete(); // মিডিয়া টেবিল থেকে রিমুভ
            }
        }

        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
