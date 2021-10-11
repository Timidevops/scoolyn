<?php


namespace App\Actions\Tenant\File;


use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileFormatException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class ExcelFileReaderAction
{
    private array $fileData = [];

    public function execute($file, array $format, $disk = 'temp'): array
    {
        if( ! Storage::disk($disk)->exists("$file") ){
            throw new FileNotFoundException("Please upload a valid file.");
        }

        $path = Storage::path("temp/$file");

        try{
            $headers = SimpleExcelReader::create($path)->headersToSnakeCase()->getHeaders();
        }catch (\Exception $e){
            Log::error("Error occurred ".$e->getMessage());
            throw new InvalidFileFormatException("Kindly use the valid file format. Please use the downloaded format.");
        }

        if( ! in_array_all($format, array_flip($headers)) ) {
            Storage::disk('temp')->delete($file);
            throw new InvalidFileFormatException("Kindly use the valid file format");
        }

        SimpleExcelReader::create($path)
            ->headersToSnakeCase()
            ->getRows()
            ->each(function(array $rowProperties) {
                $this->fileData [] = $rowProperties;
            });

        return $this->fileData;
    }
}
