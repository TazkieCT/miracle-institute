<?php

namespace Database\Seeders\Cms;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Company;
use App\Models\Slider;
use App\Models\TutorialVideo;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.test')->firstOrFail();

        $article1 = Article::factory()->create([
            'title' => 'Welcome to the LMS',
            'author' => 'System Admin',
            'content' => '<p>Welcome article for dummy content testing.</p>',
            'status' => 'active',
            'clicked' => 12,
        ]);

        $article2 = Article::factory()->create([
            'title' => 'How to Use the Learning Dashboard',
            'author' => 'System Admin',
            'content' => '<p>Step-by-step guide for users.</p>',
            'status' => 'inactive',
            'clicked' => 4,
        ]);

        ArticleImage::factory()->create([
            'article_id' => $article1->id,
            'image' => 'articles/welcome-1.jpg',
        ]);

        ArticleImage::factory()->create([
            'article_id' => $article2->id,
            'image' => 'articles/dashboard-1.jpg',
        ]);

        Company::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Grace Fellowship Church',
                'description' => 'Dummy branding data for LMS testing.',
                'address' => '123 Church Street, City',
                'vision' => 'Growing disciples through structured learning.',
                'mission' => 'Delivering discipleship and sermon learning content.',
                'logo' => 'branding/logo.png',
                'facebook' => 'https://facebook.com/example',
                'instagram' => 'https://instagram.com/example',
                'youtube' => 'https://youtube.com/example',
                'whatsapp' => 'https://wa.me/6281111111111',
            ]
        );

        Slider::factory()->count(3)->create();

        TutorialVideo::factory()->create([
            'video_link' => 'https://www.youtube.com/watch?v=video-setup-1',
            'video_name' => 'Getting Started',
        ]);

        TutorialVideo::factory()->create([
            'video_link' => 'https://www.youtube.com/watch?v=video-setup-2',
            'video_name' => 'How to Join a Session',
        ]);

        UserDocument::factory()->create([
            'user_id' => $admin->id,
            'name' => 'Admin Profile Photo',
            'image' => 'documents/admin-profile.jpg',
            'type' => 'avatar',
            'status' => 'active',
        ]);

        UserDocument::factory()->create([
            'user_id' => $admin->id,
            'name' => 'Admin ID Card',
            'image' => 'documents/admin-id-card.jpg',
            'type' => 'id_card',
            'status' => 'active',
        ]);
    }
}