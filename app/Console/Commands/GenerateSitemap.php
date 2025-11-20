<?php

namespace App\Console\Commands;

use App\Enums\Common;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

use App\Models\Post;
use App\Models\Product;
use App\Models\Page;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml using Spatie';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        // Trang chủ
        $sitemap->add(
            Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setLastModificationDate(Carbon::now())
        );

        // Bài viết
        Post::where('status', Common::PUBLISHED->value)->get()->each(function ($item) use ($sitemap) {
            $sitemap->add(
                Url::create(route('post.article', $item->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate(Carbon::parse($item->updated_at))
            );
        });

        // Sản phẩm
        Product::where('status', Common::PUBLISHED->value)->get()->each(function ($item) use ($sitemap) {
            $sitemap->add(
                Url::create(route('product.article', $item->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate(Carbon::parse($item->updated_at))
            );
        });

        // Trang tĩnh
        Page::where('status', Common::PUBLISHED->value)->get()->each(function ($item) use ($sitemap) {
            $sitemap->add(
                Url::create(route('page.article', $item->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate(Carbon::parse($item->updated_at))
            );
        });

        // Chuyên mục
        Category::where('status', Common::PUBLISHED->value)->get()->each(function ($item) use ($sitemap) {
            $sitemap->add(
                Url::create(route('category', $item->slug))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate(Carbon::parse($item->updated_at))
            );
        });

        // Ghi ra file public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap generated successfully!');
        return 0;
    }
}
