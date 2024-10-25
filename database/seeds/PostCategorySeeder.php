<?php

use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $post_category = array(
            array(
                "slug" => "human-resources",
                "name" => "人力資源",
            ),
            array(
                "slug" => "accounting-finance",
                "name" => "財務會計",
            ),
            array(
                "slug" => "business-intelligence",
                "name" => "商業分析",
            ),
            array(
                "slug" => "information-center",
                "name" => "資訊中心",
            ),
            array(
                "slug" => "account-service",
                "name" => "客戶服務",
            ),
            array(
                "slug" => "factory-management",
                "name" => "廠務管理",
            ),
            array(
                "slug" => "logistics",
                "name" => "物流配送",
            ),
            array(
                "slug" => "media-pr",
                "name" => "媒體公關",
            ),
            array(
                "slug" => "retirement",
                "name" => "退休規劃",
            ),
            array(
                "slug" => "welfare-committee",
                "name" => "職工福利",
            ),
        );

        foreach($post_category as $category)
        {
            \App\PostCategory::create([
                'slug' => $category['slug'],
                'name' => $category['name']
            ]);
        }
    }
}
