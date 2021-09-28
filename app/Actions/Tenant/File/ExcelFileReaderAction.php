<?php


namespace App\Actions\Tenant\File;


use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileFormatException;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class ExcelFileReaderAction
{
    private array $fileData = [];

    public function execute($file, array $format): array
    {
        if( ! Storage::disk('temp')->exists("$file") ){
            dd('here');
            throw new FileNotFoundException("Please upload a valid file.");
        }

        $path = Storage::path("temp/$file");

        $headers = SimpleExcelReader::create($path)->headersToSnakeCase()->getHeaders();

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
