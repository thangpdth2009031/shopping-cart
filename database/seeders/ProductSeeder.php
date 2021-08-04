<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('products')->truncate();
        DB::table('products')->insert([
            [
                'name' => 'Adidas X Ghosted + FG Superspectral - Shock Pink',
                'thumbnail' => 'https://thumblr.uniid.it/product/211686/28fa9cebc064.jpg',
                'price' => 223.95,
                'created_at' => Carbon::now(-9)
            ],
            [
                'name' => 'Nike Mercurial Superfly 8 Elite FG Rawdacious - White/Bright Crimson/Pink Blast',
                'thumbnail' => 'https://thumblr.uniid.it/product/226698/53f623769e91.jpg',
                'price' => 269.95,
                'created_at' => Carbon::now(-16)
            ],
            [
                'name' => 'Nike Mercurial Superfly 8 Elite FG Dragonfly - White/Metallic Silver/Dark Raisin',
                'thumbnail' => 'https://thumblr.uniid.it/product/213577/78f8bd263520.jpg',
                'price' => 245.98,
                'created_at' => Carbon::now(-1)
            ],
            [
                'name' => 'Nike Mercurial Vapor 13 Elite FG Mbappé Rosa - Pink Blast',
                'thumbnail' => 'https://thumblr.uniid.it/product/206026/7925efbbf6e8.jpg',
                'price' => 269.89,
                'created_at' => Carbon::now(-4)
            ],
            [
                'name' => 'Adidas Predator Freak + FG Showpiece - Silver Metallic',
                'thumbnail' => 'https://thumblr.uniid.it/product/211730/788506b2dc6a.jpg',
                'price' => 279.95,
                'created_at' => Carbon::now(-3)
            ],
            [
                'name' => 'Adidas Predator Freak + FG Superspectral - Core Black',
                'thumbnail' => 'https://thumblr.uniid.it/product/211809/fa99d27ec41a.jpg',
                'price' => 237.95,
                'created_at' => Carbon::now(-2)
            ],
            [
                'name' => 'Adidas Nemeziz + FG Superspectral - Footwear White/Screaming Orange/Core Black',
                'thumbnail' => 'https://thumblr.uniid.it/product/211750/99cf31a97c61.jpg',
                'price' => 206.98,
                'created_at' => Carbon::now(-1)
            ],
            [
                'name' => 'Mizuno Rebula III Cup Made in Japan FG Next Wave - White',
                'thumbnail' => 'https://thumblr.uniid.it/product/226725/e1d25a5d074d.jpg',
                'price' => 309.95,
                'created_at' => Carbon::now(-6)
            ],
            [
                'name' => 'Nike Mercurial Superfly 8 Elite FG CR7 Spark Positivity - Chile Red',
                'thumbnail' => 'https://thumblr.uniid.it/product/226697/71b66ea9ab82.jpg',
                'price' => 289.95,
                'created_at' => Carbon::now(-1)
            ],
            [
                'name' => 'Adidas X Ghosted + FG Inflight - Footwear White',
                'thumbnail' => 'https://thumblr.uniid.it/product/203856/bfcdcd0bdec0.jpg',
                'price' => 211.98,
                'created_at' => Carbon::now(-3)
            ]
        ]);
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
