<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Genesis Admin',
            'email' => 'admin@genesis.org.zw',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Dr. Herbert Sibanda',
            'email' => 'staff@genesis.org.zw',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        $patientUser = User::create([
            'name' => 'Chipo Moyo',
            'email' => 'patient@genesis.org.zw',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);

        // Seed Patient Profile for Chipo
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone' => '+263 77 123 4567',
            'date_of_birth' => '1992-05-14',
            'gender' => 'Female',
            'address' => '12 Malvern Road, Mount Pleasant, Harare',
            'medical_history' => 'Hypertension managed with medication.',
        ]);

        // Add secondary patient for demo
        $patientUser2 = User::create([
            'name' => 'Tendai Ndlovu',
            'email' => 'tendai@genesis.org.zw',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);

        $patient2 = Patient::create([
            'user_id' => $patientUser2->id,
            'phone' => '+263 71 987 6543',
            'date_of_birth' => '1985-11-22',
            'gender' => 'Male',
            'address' => '45 Fife Avenue, Avenues, Harare',
            'medical_history' => 'Asthmatic. No other chronic conditions.',
        ]);

        // 2. Seed Services
        $services = [
            [
                'name' => 'General Medical Consultation',
                'slug' => 'general-consultation',
                'description' => 'Comprehensive check-up, vital signs checking, diagnosis and general prescription with one of our certified medical officers.',
                'duration' => 30,
                'price' => 20.00,
                'is_active' => true,
            ],
            [
                'name' => 'Wellness Assessment & Nutrition Planning',
                'slug' => 'wellness-assessment',
                'description' => 'Personalized health risk assessments, lifestyle counseling, body mass index calculations and customized diet/exercise guidance.',
                'duration' => 60,
                'price' => 45.00,
                'is_active' => true,
            ],
            [
                'name' => 'Chronic Disease Management Program',
                'slug' => 'chronic-disease-management',
                'description' => 'Assistance with routine check-ups, medicine scheduling guidance, diet adjustments, and regular health markers tracking for Diabetes or Hypertension.',
                'duration' => 45,
                'price' => 30.00,
                'is_active' => true,
            ],
            [
                'name' => 'Home Care & Physical Visits',
                'slug' => 'home-care-visits',
                'description' => 'Providing medical checks, wound care, and standard vital tracking in the comfort of your own home within Harare metropolitan area.',
                'duration' => 90,
                'price' => 60.00,
                'is_active' => true,
            ],
            [
                'name' => 'Physiotherapy & Rehabilitation',
                'slug' => 'physiotherapy-rehab',
                'description' => 'Therapeutic exercises, structural support rehabilitation, and tailored physical therapy plans designed to restore body functionality.',
                'duration' => 60,
                'price' => 40.00,
                'is_active' => true,
            ],
        ];

        foreach ($services as $srv) {
            Service::create($srv);
        }

        // 3. Seed Testimonials
        Testimonial::create([
            'patient_id' => $patient->id,
            'client_name' => 'Chipo Moyo',
            'client_title' => 'Chronic Disease Management Patient',
            'content' => 'Genesis Goodhope has completely transformed my health. Their chronic disease program keeps my blood pressure under control, and the home visit checks are so convenient!',
            'rating' => 5,
            'is_approved' => true,
        ]);

        Testimonial::create([
            'patient_id' => $patient2->id,
            'client_name' => 'Tendai Ndlovu',
            'client_title' => 'Wellness Program Client',
            'content' => 'The wellness consultation gave me a customized exercise and nutrition plan that fits my busy schedule. Highly recommend Dr. Sibanda and the staff!',
            'rating' => 5,
            'is_approved' => true,
        ]);

        Testimonial::create([
            'patient_id' => null,
            'client_name' => 'Munya Gumbo',
            'client_title' => 'Corporate Client',
            'content' => 'Wonderful team! They ran our corporate health screenings with absolute professionalism. Quick results and clear instructions.',
            'rating' => 4,
            'is_approved' => true,
        ]);

        // 4. Seed Blogs
        Blog::create([
            'title' => 'Understanding and Managing Hypertension in Zimbabwe',
            'slug' => 'managing-hypertension-zimbabwe',
            'content' => "Hypertension, commonly known as high blood pressure, affects a significant percentage of the adult population in Zimbabwe. This blog article breaks down the major risk factors, local dietary considerations (such as reducing sodium in traditional dishes), and the vital importance of regular health checkups.\n\n### What is Hypertension?\nHypertension is when the pressure in your blood vessels is too high (140/90 mmHg or higher). It is common but can be serious if left untreated. Many people with high blood pressure do not feel any symptoms, which is why it is often referred to as a 'silent killer'.\n\n### Lifestyle Changes\n1. **Eat healthy**: Focus on whole grains, fruits, vegetables, and low-fat dairy. Avoid high fat and high sodium foods.\n2. **Exercise regularly**: Walk at least 30 minutes a day.\n3. **Manage stress**: Find healthy coping mechanisms.",
            'image_path' => null,
            'author_id' => $staff->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

        Blog::create([
            'title' => '5 Simple Tips for Building a Robust Winter Wellness Plan',
            'slug' => 'winter-wellness-plan-harare',
            'content' => "As temperatures drop during Harare winters, keeping active and nourishing our bodies becomes a priority. In this article, we outline five easy practices to support your immune system, stay hydrated, and maintain physical wellness through the colder season.\n\n1. **Boost Vitamin C Intake**: Consume citrus fruits like oranges and naartjies which are abundant locally.\n2. **Stay Hydrated**: Even if you don't feel thirsty, keep drinking clean water.\n3. **Maintain Exercise**: Work out indoors or do light jogs when the afternoon sun is out.\n4. **Get Enough Sleep**: A well-rested body has a stronger immune response.",
            'image_path' => null,
            'author_id' => $staff->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

        Blog::create([
            'title' => 'An Overview of Diabetes: Prevention and Control',
            'slug' => 'diabetes-prevention-and-control',
            'content' => "Diabetes mellitus is a chronic condition that occurs when the pancreas does not produce enough insulin or when the body cannot effectively use the insulin it produces. Learn the differences between Type 1 and Type 2 diabetes, common symptoms like excessive thirst and fatigue, and how you can prevent Type 2 diabetes through structured healthy living.",
            'image_path' => null,
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // 5. Seed Settings
        $settings = [
            'site_name' => 'Genesis Goodhope Population Health',
            'site_email' => 'info@genesis.org.zw',
            'site_phone' => '071 216 2369',
            'whatsapp_number' => '263712162369',
            'address' => 'Genesis Goodhope Health Office, Harare, Zimbabwe',
            'working_hours' => 'Mon - Fri: 8:00 AM - 5:00 PM, Sat: 8:00 AM - 1:00 PM',
            'hero_title' => 'Empowering Health & Wellness in Zimbabwe',
            'hero_subtitle' => 'Genesis Goodhope Population Health is dedicated to delivering professional, community-centered healthcare, wellness, and preventive care programs.',
            'about_content' => 'Genesis Goodhope Population Health is a health and wellness organization based in Harare, Zimbabwe. Our mission is to promote population health, deliver preventive care, manage chronic diseases, and offer convenient healthcare booking options to individuals and organizations across the country.',
            'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d121575.40578508493!2d30.985923984164344!3d-17.82485806622416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1931a4e70afb1ce3%3A0xec80a87677bf18!2sHarare%2C%20Zimbabwe!5e0!3m2!1sen!2szw!4v1717900000000!5m2!1sen!2szw" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ];

        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }
    }
}
