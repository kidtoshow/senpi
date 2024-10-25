<?php

use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skill = array(
            array(
                "slug" => "negotiation",
                "name" => "談判",
            ),
            array(
                "slug" => "languate",
                "name" => "語言",
            ),
            array(
                "slug" => "programing",
                "name" => "程式",
            ),
            array(
                "slug" => "executive",
                "name" => "管理",
            ),
            array(
                "slug" => "communication",
                "name" => "溝通",
            ),
            array(
                "slug" => "bargain",
                "name" => "議價",
            ),
            array(
                "slug" => "documents",
                "name" => "文書",
            ),
            array(
                "slug" => "rd",
                "name" => "研發",
            ),
            array(
                "slug" => "creativity",
                "name" => "創意",
            ),
            array(
                "slug" => "customer-relationship",
                "name" => "客情",
            ),
            array(
                "slug" => "design",
                "name" => "設計",
            ),
            array(
                "slug" => "research",
                "name" => "研究",
            ),
            array(
                "slug" => "organization",
                "name" => "組織",
            ),
            array(
                "slug" => "leadership",
                "name" => "領導",
            ),
            array(
                "slug" => "customer-service",
                "name" => "客服",
            ),
            array(
                "slug" => "coach",
                "name" => "教練",
            ),
            array(
                "slug" => "conflict",
                "name" => "衝突",
            ),
            array(
                "slug" => "execution-ability",
                "name" => "執行",
            ),
            array(
                "slug" => "sales",
                "name" => "銷售",
            ),
            array(
                "slug" => "foreigner",
                "name" => "外籍",
            ),
            array(
                "slug" => "sympathy",
                "name" => "同理",
            ),
            array(
                "slug" => "planning",
                "name" => "企劃",
            ),
            array(
                "slug" => "operation",
                "name" => "運營",
            ),
            array(
                "slug" => "government",
                "name" => "政府",
            ),
            array(
                "slug" => "slash",
                "name" => "斜槓",
            ),
            array(
                "slug" => "team-building",
                "name" => "團建",
            ),
            array(
                "slug" => "kpi",
                "name" => "指標",
            ),
            array(
                "slug" => "long-distance",
                "name" => "遠距",
            ),
            array(
                "slug" => "pet",
                "name" => "寵物",
            ),
            array(
                "slug" => "numerology",
                "name" => "命理",
            ),
            array(
                "slug" => "project-management",
                "name" => "專案",
            ),
            array(
                "slug" => "over-seas",
                "name" => "海外",
            ),
            array(
                "slug" => "sport",
                "name" => "運動",
            ),
            array(
                "slug" => "writing",
                "name" => "寫作",
            ),
            array(
                "slug" => "statistics",
                "name" => "統計",
            ),
            array(
                "slug" => "audit",
                "name" => "稽核",
            ),
            array(
                "slug" => "health",
                "name" => "健康",
            ),
            array(
                "slug" => "travel",
                "name" => "旅行",
            ),
            array(
                "slug" => "actuary",
                "name" => "精算",
            ),
            array(
                "slug" => "retirement",
                "name" => "退休",
            ),
        );

        foreach($skill as $item) {
            \App\Skill::create([
                'slug' => $item['slug'],
                'name' => $item['name']
            ]);
        }
    }
}
