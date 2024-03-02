<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        $this->call(SchoolYearTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SystemAdminSeeder::class);
        $this->call(GradeSectionSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(CoCurricularActivitySeeder::class);
        $this->call(SubjectTableSeeder::class);
        // $this->call(StudentTableSeeder::class);
        // $this->call(GradePerSubjectSeeder::class);
        // $this->call(ClassSeeder::class);
    }

}
