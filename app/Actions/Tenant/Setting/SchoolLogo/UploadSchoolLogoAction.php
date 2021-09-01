<?php


namespace App\Actions\Tenant\Setting\SchoolLogo;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadSchoolLogoAction
{
    public function execute($file)
    {
        $getFile = File::get($file);

        $tempName = 'school_logo_'.random_number('1','9','7');

        $file = "{$tempName}.{$file->extension()}";

        Storage::disk('local')->put($file,$getFile);

        return $file;
    }
}
