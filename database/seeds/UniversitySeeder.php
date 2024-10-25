<?php

use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $universities = [
            ['english_name'=>'Agriculture Forestry Fishing and Animal Husbandry','chinese_name'=>'農林漁牧','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID1'],
            ['english_name'=>'Mining and Quarrying','chinese_name'=>'礦業及土石採取','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID2'],
            ['english_name'=>'Manufacturing','chinese_name'=>'製造','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID3'],
            ['english_name'=>'Electricity and Gas Supply','chinese_name'=>'電力及燃氣供應','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID4'],
            ['english_name'=>'Water Supply and Remediation Activities','chinese_name'=>'用水供應及污染整治','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID5'],
            ['english_name'=>'Construction','chinese_name'=>'營建工程','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID6'],
            ['english_name'=>'Wholesale and Retail Trade','chinese_name'=>'批發及零售','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID7'],
            ['english_name'=>'Transportation and Storage','chinese_name'=>'運輸及倉儲','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID8'],
            ['english_name'=>'Accommodation and Food Service Activities','chinese_name'=>'住宿及餐飲','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID9'],
            ['english_name'=>'Information and Communication','chinese_name'=>'出版影音製作傳播及資通訊服務','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID10'],
            ['english_name'=>'Financial and Insurance Activities','chinese_name'=>'金融及保險','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID11'],
            ['english_name'=>'Real Estate Activities','chinese_name'=>'不動產','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID12'],
            ['english_name'=>'Professional Scientific and Technical Activities','chinese_name'=>'專業科學及技術服務','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID13'],
            ['english_name'=>'Support Service Activities','chinese_name'=>'支援服務','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID14'],
            ['english_name'=>'Public Administration and Defence; Compulsory Social Security','chinese_name'=>'公共行政及國防強制性社會安全','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID15'],
            ['english_name'=>'Education','chinese_name'=>'教育','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID16'],
            ['english_name'=>'Human Health and Social Work Activities','chinese_name'=>'醫療保健及社會工作服務','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID17'],
            ['english_name'=>'Arts Entertainment and Recreation','chinese_name'=>'藝術娛樂及休閒服務','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID18'],
            ['english_name'=>'Other Service Activities','chinese_name'=>'其他服務','country'=>'TAIWAN','area'=>NULL,'state'=>NULL,'school_badge'=>'TWID19'],
        ];

//        \App\University::insert($universities);
        foreach($universities as $university){
            \App\University::create([
                'slug' => str_slug($university['english_name']),
                'name' => $university['chinese_name'],
                'english_name' => $university['english_name'],
                'chinese_name' => $university['chinese_name'],
                'country' => \Illuminate\Support\Str::upper($university['country']),
//                'area' => \Illuminate\Support\Str::upper($university['area']),
//                'state' => \Illuminate\Support\Str::upper($university['state']),
                'school_badge' => \Illuminate\Support\Str::upper($university['school_badge']),
                'image_path' => 'university/'.\Illuminate\Support\Str::upper($university['country']).'/'.\Illuminate\Support\Str::upper($university['school_badge']).'.png'
            ]);
        }
    }
}
