<?php

namespace Tests\Feature\Tenant\Setting;

use App\Models\Tenant\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SetCurrentAcademicCalendarControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_set_current_academic_calendar_is_stored()
    {
        $response = $this->post('/setting/set-academic-calendar', [
            'settingName' => Setting::ACADEMIC_CALENDAR_SETTING,
            'term' => 'third term',
            'session' => '2020/2021',
        ]);

        $response->assertRedirect('/');
        $getSetCurrentAcademicCalendar = Setting::all()->first();

        $this->assertEquals(Setting::ACADEMIC_CALENDAR_SETTING, $getSetCurrentAcademicCalendar->setting_name);
        $this->assertEquals('third term', $getSetCurrentAcademicCalendar->meta['term']);
        $this->assertEquals('2020/2021', $getSetCurrentAcademicCalendar->meta['session']);
    }
}
