<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Front-end Routes
Route::get('/', function () {
    $services = Service::where('is_active', true)->limit(3)->get();
    $testimonials = Testimonial::where('is_approved', true)->limit(6)->get();
    $blogs = Blog::with('author')->where('is_published', true)->orderBy('published_at', 'desc')->limit(3)->get();
    return view('public.home', compact('services', 'testimonials', 'blogs'));
})->name('home');

Route::get('/about', function () {
    return view('public.about');
})->name('about');

Route::get('/services', function () {
    $services = Service::where('is_active', true)->get();
    return view('public.services', compact('services'));
})->name('services');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Appointment Booking Routes
Route::get('/book', [BookingController::class, 'index'])->name('booking.index');
Route::get('/book/slots', [BookingController::class, 'getAvailableSlots'])->name('booking.slots');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');

// Unified Dashboard Redirector
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Patient Portal Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{appointment}/cancel', function (\App\Models\Appointment $appointment) {
        if ($appointment->patient->user_id !== Auth::id()) {
            abort(403);
        }
        $appointment->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    })->name('appointments.cancel');
});

// Admin & Staff Dashboard Routes
Route::middleware(['auth', 'role:admin,staff'])->prefix('dashboard')->name('admin.')->group(function () {
    // Appointment Management
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/export', [AppointmentController::class, 'exportCsv'])->name('appointments.export');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::get('/appointments/{appointment}/print', [AppointmentController::class, 'printInvoice'])->name('appointments.print');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Patient Directory
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');

    // Services CRUD
    Route::resource('services', ServiceController::class)->except(['show']);

    // Blogs CRUD
    Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

    // Testimonials Moderation
    Route::get('/testimonials', [SettingsController::class, 'testimonialsIndex'])->name('testimonials.index');
    Route::post('/testimonials/{testimonial}/approve', [SettingsController::class, 'approveTestimonial'])->name('testimonials.approve');
    Route::delete('/testimonials/{testimonial}', [SettingsController::class, 'destroyTestimonial'])->name('testimonials.destroy');

    // Contact Messages Inbox
    Route::get('/contact-messages', [ContactController::class, 'adminIndex'])->name('contact.index');
    Route::get('/contact-messages/{message}', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact-messages/{message}/toggle-read', [ContactController::class, 'toggleRead'])->name('contact.toggle-read');
    Route::delete('/contact-messages/{message}', [ContactController::class, 'destroy'])->name('contact.destroy');

    // Admin-Only Routes
    Route::middleware(['role:admin'])->group(function () {
        // Staff Management CRUD
        Route::resource('staff', StaffController::class)->parameters(['staff' => 'staff']);

        // General Website Content Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });
});

// Profile Management Routes (Standard Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


