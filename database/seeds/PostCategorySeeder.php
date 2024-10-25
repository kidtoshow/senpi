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
                'image_path' => 'images/human-resources.png',
            ),
            array(
                "slug" => "accounting-finance",
                "name" => "財務會計",
                'image_path' => 'images/accounting-finance.png',
            ),
            array(
                "slug" => "business-intelligence",
                "name" => "商業分析",
                'image_path' => 'images/business-intelligence.png',
            ),
            array(
                "slug" => "information-center",
                "name" => "資訊中心",
                'image_path' => 'images/information-center.png',
            ),
            array(
                "slug" => "account-service",
                "name" => "客戶服務",
                'image_path' => 'images/account-service.png',
            ),
            array(
                "slug" => "factory-management",
                "name" => "廠務管理",
                'image_path' => 'images/factory-management.png',
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
            if(isset($category['image_path'])){
                \App\PostCategory::create([
                    'slug' => $category['slug'],
                    'name' => $category['name'],
                    'image_path' => $category['image_path'],
                ]);
            }else {
                \App\PostCategory::create([
                    'slug' => $category['slug'],
                    'name' => $category['name']
                ]);
            }
        }
    }
}
