<?php


namespace App\Actions\Tenant\Setting\PrincipalDetails;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadPrincipalSignatureAction
{
    public function execute($file)
    {
        $getFile = File::get($file);

        $tempName = 'principal_signature_'.random_number('1','9','7');

        $file = "{$tempName}.{$file->extension()}";

        Storage::disk('local')->put($file,$getFile);

        return $file;
    }
}
