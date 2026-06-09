<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:20',
            'whatsapp_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'working_hours' => 'required|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500',
            'about_content' => 'required|string',
            'google_maps_embed' => 'nullable|string',
        ]);

        foreach ($request->only([
            'site_name', 'site_email', 'site_phone', 'whatsapp_number', 
            'address', 'working_hours', 'hero_title', 'hero_subtitle', 
            'about_content', 'google_maps_embed'
        ]) as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->back()->with('success', 'Website settings updated successfully.');
    }

    // Testimonials admin actions
    public function testimonialsIndex()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approveTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);
        $status = $testimonial->is_approved ? 'approved' : 'unapproved';
        return redirect()->back()->with('success', "Testimonial has been marked as {$status}.");
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
}
