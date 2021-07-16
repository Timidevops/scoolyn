<?php

namespace Database\Seeders;

use App\Models\Tenant\Subject;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class SubjectSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects =  [
            'mathematics',
            'English Language',
            'Yoruba',
            'Basic Science and Technology',
            'Pre-Vocational Studies',
            'Religion and Value Education',
            'Cultural and Creative Art',
            'French Language',
            'Business Studies',
            'Agricultural Science',
            'Physics',
            'Chemistry',
            'Biology',
            'Geography',
            'Economics',
            'Government',
            'Literature-in–English',
            'Commerce',
            'Financial Accounting',
            'Further Mathematics',
            'Technical Drawing'
        ];

        foreach ($subjects as $subject){
            Subject::query()->create([
                'uuid' => (string) Uuid::uuid4(),
                'subject_name' => strtolower($subject),
            ]);
        }

    }
}
