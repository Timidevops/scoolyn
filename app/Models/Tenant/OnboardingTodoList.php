<?php


namespace App\Models\Tenant;


class OnboardingTodoList
{
    const SET_ACADEMIC_CALENDAR = 'set_academic_calendar';
    const ADD_SCHOOL_CLASSES = 'add_school_classes';
    const ADD_SUBJECT = 'add_subject';
    const ADD_CA_FORMAT = 'add_ca_format';
    const ADD_GRADING_FORMAT = 'add_grading_format';
    const ADD_STUDENT = 'add_student';
    const ADD_PARENT = 'add_parent';
    const ADD_TEACHER = 'add_teacher';
    const SET_SCHOOL_DETAIL = 'set_school_detail';

    public static function setting()
    {
        return Setting::whereSettingName(Setting::INITIAL_TODO_SETTING)->first();
    }

    public static function isTodoListCompleted() :bool
    {
        return self::setting()->setting_value;
    }

    public static function isTodoItemCompleted(string $itemName): bool
    {
        $setting = self::setting();

        return (bool) collect($setting->meta)->whereIn('name', $itemName)->first()['done'];
    }

    public static function markTodoItemComplete(string $itemName)
    {
        $setting = self::setting();

        $todoItems = collect($setting->meta)->whereNotIn('name',  $itemName);

        $todoItem = collect($setting->meta)->whereIn('name',  $itemName)->first();

        $todoItems->push([
            'name' => $itemName,
            'done' => '1',
//            'description' => $todoItem['description'],
//            'url' => $todoItem['url'],
        ]);

        //save settings
        $setting->update([
            'meta' => $todoItems->values(),
        ]);

    }
}
