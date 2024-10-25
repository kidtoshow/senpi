<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AboutUsContentSeeder::class);
        $this->call(ContractSeeder::class);
        $this->call(PostCategorySeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(UniversitySeeder::class);
        $this->call(YizixueFaqCarouselSeeder::class);
        $this->call(YizixueFaqSeeder::class);
    }
}
