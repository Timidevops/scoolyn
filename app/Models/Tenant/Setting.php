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
    const PAYMENT_CURRENCY = 'payment_currency';
    const PAYMENT_STATUS = 'payment_status';
    const ADMISSION_STATUS = 'admission_status';
    const PRINCIPAL_INFO = 'principal_info';
    const SCHOOL_LOGO = 'school_logo';
    const INITIAL_TODO_SETTING = 'initial_todo';

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

    public static function schoolDetails(): array
    {
        return [
            'schoolName' => self::whereSettingName(self::SCHOOL_NAME_SETTING)->first()->setting_value,
            'schoolLocation' => self::whereSettingName(self::SCHOOL_LOCATION_SETTING)->first()->setting_value,
            'contactNumber' => self::whereSettingName(self::CONTACT_NUMBER_SETTING)->first()->setting_value,
            'contactEmail' => self::whereSettingName(self::CONTACT_EMAIL_SETTING)->first()->setting_value,
            'schoolType' => self::whereSettingName(self::SCHOOL_TYPE_SETTING)->first()->setting_value,
        ];
    }

    public static function getSchoolLogo()
    {
        return self::whereSettingName(self::SCHOOL_LOGO)->exists()
            ? self::whereSettingName(self::SCHOOL_LOGO)->first()
            : '';
    }

    public static function getSchoolPrincipal(): array
    {
        $principal = self::whereSettingName(self::PRINCIPAL_INFO)->first();

        if ( ! $principal ){
            return [];
        }

        return [
            'principalName' => $principal->meta['principal_name'],
            'principalSignature' => $principal->meta['principal_signature'],
        ];
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
            return  'current academic calendar not set.';
        }

        $academicSession = AcademicSession::query()->where('uuid', $setting->meta['session'])->first();

        $academicTerm = AcademicTerm::query()->where('uuid', $setting->meta['term'])->first();

        return "$academicSession->session_name, ".strOrdinal($academicTerm->term_name)." term";
    }

    public static function isAcademicCalendarSet(): bool
    {
        return self::query()->where('setting_name', self::ACADEMIC_CALENDAR_SETTING)->exists();
    }

    public static function isAdmissionOn() : bool
    {
        return self::query()->where('setting_name', self::ADMISSION_STATUS)->first()->setting_value;
    }

    public static function isPaymentStatusOn()
    {
        return (bool) self::query()->where('setting_name', self::PAYMENT_STATUS)->first()->setting_value;
    }
}
