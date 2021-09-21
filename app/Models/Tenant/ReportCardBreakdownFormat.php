<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class ReportCardBreakdownFormat extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesTenantConnection;

    protected $guarded = [];

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }

    public static function currentFormatPlacementId()
    {
        return collect( collect(self::all()->toArray() )->where('uuid', Setting::getCurrentCardBreakdownFormat()) )->keys()->first();;
    }

    public static function checkIfBroadSheetReportCardIsNext(Model $classSubject): bool
    {
        /**
         * this check if the current selected report card breakdown format is the right to be displayed.
         * checks by getting the previous report card breakdown format and checks if broadsheet record exists for class subject...
         */

        $currentFormat = Setting::getCurrentCardBreakdownFormat();

        $currentFormatPlacementId = collect( collect(self::all()->toArray() )->where('uuid', $currentFormat) )->keys()->first();

        $checker = true;

        for ($i = 0; $i < self::query()->count(); $i++){
            if ( $i == $currentFormatPlacementId ){

                $previousReport = self::getPreviousReportCard();

                if($previousReport == null) { continue;}

                $checker = $classSubject->academicBroadsheet()->where('report_card', $previousReport)->exists();

            }
        }

        return $checker;

    }

    public static function getPreviousReportCard()
    {
        $index = self::currentFormatPlacementId() - 1;

        return collect( self::all()->toArray() )->get($index) ? collect( self::all()->toArray() )->get($index)['uuid'] : null;
    }
}
