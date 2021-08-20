<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    const ACADEMIC_CALENDAR_SETTING = 'current_academic_calendar';
    const SCHOOL_NAME_SETTING = 'school_name';
    const SCHOOL_LOCATION_SETTING = 'school_location';
    const CONTACT_NUMBER_SETTING = 'contact_number';
    const CONTACT_EMAIL_SETTING = 'contact_email';
    const SCHOOL_TYPE_SETTING = 'school_type';
    const PAYMENT_CURRENCY = 'payment_currency_';
    const ADMISSION_STATUS = 'admission_status';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('setting_name')
            ->saveSlugsTo('slug');
    }

    public static function whereSettingName(string $settingName)
    {
        return self::query()->where('setting_name', $settingName);
    }

    public static function getCurrentAcademicSessionId()
    {
        $setting = self::query()->where('setting_name', self::ACADEMIC_CALENDAR_SETTING)->first();

        return $setting->meta['session'];
    }

    public static function getCurrentAcademicTermId()
    {
        $setting = self::query()->where('setting_name', self::ACADEMIC_CALENDAR_SETTING)->first();

        return $setting->meta['term'];
    }

    public static function getCurrentAcademicCalendarInWord(): String
    {
        $setting = self::query()->where('setting_name', self::ACADEMIC_CALENDAR_SETTING)->first();

        if( ! $setting ){
            return  'current session not set.';
        }

        $academicSession = AcademicSession::query()->where('uuid', $setting->meta['session'])->first();

        $academicTerm = AcademicTerm::query()->where('uuid', $setting->meta['term'])->first();

        return "$academicSession->session_name, $academicTerm->term_name";
    }

    public static function isAdmissionOn() : bool
    {
        $setting = self::query()->where('setting_name', self::ADMISSION_STATUS)->first();

        return (bool) $setting->setting_value;
    }
}
