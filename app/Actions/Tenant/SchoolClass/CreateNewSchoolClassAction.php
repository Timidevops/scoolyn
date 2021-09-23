<?php


namespace App\Actions\Tenant\SchoolClass;


use App\Models\Tenant\SchoolClass;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolClassAction
{
    public function execute(array $input)
    {
        switch ($class = $input['class_name']){
            case $class == 'Junior Secondary School 1':
                $input['level'] = 1;
                break;
            case $class == 'Junior Secondary School 2':
                $input['level'] = 2;
                break;
            case $class == 'Junior Secondary School 3':
                $input['level'] = 3;
                break;
            case $class == 'Senior Secondary School 1':
                $input['level'] = 4;
                break;
            case $class == 'Senior Secondary School 2':
                $input['level'] = 5;
                break;
            case $class == 'Senior Secondary School 3':
                $input['level'] = 6;
                break;
        }

        $input['uuid'] = Uuid::uuid4();
        return SchoolClass::query()->create($input);
    }
}
