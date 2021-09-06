<?php


namespace App\Actions\Tenant\File;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileAction
{
    public function execute(array $input)
    {
        $getFile = File::get($input['file']);

        $tempName = $input['fileName'].random_number('1','9','7');

        $file = "{$tempName}.{$input['file']->extension()}";

        Storage::disk('local')->put($file,$getFile);

        return $file;
    }
}
