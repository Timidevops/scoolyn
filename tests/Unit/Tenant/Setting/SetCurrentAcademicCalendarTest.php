<?php

namespace Tests\Unit\Tenant\Setting;


use App\Actions\Tenant\Setting\SetCurrentAcademicCalendarAction;
use App\Models\Tenant\Setting;
use Tests\TestCase;

class SetCurrentAcademicCalendarTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_academic_calendar_is_set_to_current()
    {
        (new SetCurrentAcademicCalendarAction())->execute([
            'setting_name' => Setting::ACADEMIC_CALENDAR_SETTING,
            'meta' => [
                'term' => 'third term',
                'session' => '2020/2021',
            ],
        ]);

        $getSetCurrentAcademicCalendar = Setting::all()->first();

        $this->assertEquals(Setting::ACADEMIC_CALENDAR_SETTING, $getSetCurrentAcademicCalendar->setting_name);
        $this->assertEquals('third term', $getSetCurrentAcademicCalendar->meta['term']);
        $this->assertEquals('2020/2021', $getSetCurrentAcademicCalendar->meta['session']);
    }
}
