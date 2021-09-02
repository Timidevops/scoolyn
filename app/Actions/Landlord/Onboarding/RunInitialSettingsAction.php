<?php


namespace App\Actions\Landlord\Onboarding;


use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\Setting;

class RunInitialSettingsAction
{
    public function execute(array $input)
    {
        Setting::query()->create([
            'setting_name' => Setting::SCHOOL_NAME_SETTING,
            'setting_value' => $input['school_name'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::SCHOOL_LOCATION_SETTING,
            'setting_value' => $input['school_location'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::CONTACT_NUMBER_SETTING,
            'setting_value' => $input['contact_number'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::CONTACT_EMAIL_SETTING,
            'setting_value' => $input['school_email'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::SCHOOL_TYPE_SETTING,
            'setting_value' => $input['school_type'],
        ]);

        $paymentStatus = 0;
        if($input['has_payment'] == 'yes'){

            $paymentStatus = 1;

            Setting::query()->create([
                'setting_name' => Setting::PAYMENT_CURRENCY,
                'setting_value' => $input['payment_currency'],
            ]);
        }

        Setting::query()->create([
            'setting_name' => Setting::PAYMENT_STATUS,
            'setting_value' => (string) $paymentStatus,
        ]);

        Setting::query()->create([
            'setting_name' => Setting::ADMISSION_STATUS,
            'setting_value' => '0',
        ]);

        Setting::query()->create([
            'setting_name' => Setting::INITIAL_TODO_SETTING,
            'setting_value' => '0',
            'meta' =>  [
                [
                    'name' => OnboardingTodoList::SET_ACADEMIC_CALENDAR,
                    'done' => 0,
                    'description' => 'Goto settings to set academic calendar',
                    'url' => 'academicSession',
                ],
                [
                    'name' => OnboardingTodoList::ADD_SCHOOL_CLASSES,
                    'done' => 0,
                    'description' => 'Goto Classes to add class arm',
                    'url' => 'listClass',
                ],
                [
                    'name' => OnboardingTodoList::ADD_SUBJECT,
                    'done' => 0,
                    'description' => 'Goto subject to add subject',
                    'url' => 'listSubject',
                ],
                [
                    'name' => OnboardingTodoList::ADD_CA_FORMAT,
                    'done' => 0,
                    'description' => 'Goto Results / Continuous assessment format to c.a format',
                    'url' => 'createCAStructure',
                ],
                [
                    'name' => OnboardingTodoList::ADD_GRADING_FORMAT,
                    'done' => 0,
                    'description' => 'Goto Results / Academic grading format to add grading format',
                    'url' => 'createGradeFormat',
                ],
                [
                    'name' => OnboardingTodoList::ADD_STUDENT,
                    'done' => 0,
                    'description' => 'Goto Users / Student to add student',
                    'url' => 'createStudent',
                ],
                [
                    'name' => OnboardingTodoList::ADD_PARENT,
                    'done' => 0,
                    'description' => 'Goto Users / Student to add parent',
                    'url' => 'createParent',
                ],
                [
                    'name' => OnboardingTodoList::ADD_TEACHER,
                    'done' => 0,
                    'description' => 'Goto Users / Student to add teacher',
                    'url' => 'createTeacher',
                ],
                [
                    'name' => OnboardingTodoList::SET_SCHOOL_DETAIL_LOGO,
                    'done' => 0,
                    'description' => 'Goto settings / School details to set school logo',
                    'url' => 'schoolDetailsSettings',
                ],
                [
                    'name' => OnboardingTodoList::SET_SCHOOL_DETAIL_PRINCIPAL,
                    'done' => 0,
                    'description' => 'Goto settings / School details to set school principal',
                    'url' => 'schoolDetailsSettings',
                ],
            ],
        ]);
    }
}
