<?php


namespace App\Actions\Tenant\guestDomain\Admission;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadPassportAction
{
    public function execute(array $input)
    {
        $getFile = File::get($input['passport']);

        $tempName = $input['firstName'].$input['lastName'].'_'.random_number('1','9','7');

        $file = "{$tempName}.{$input['passport']->extension()}";

        Storage::disk('local')->put($file,$getFile);

        return $file;
    }
}
