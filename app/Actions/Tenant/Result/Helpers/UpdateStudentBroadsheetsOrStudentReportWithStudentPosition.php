<?php


namespace App\Actions\Tenant\Result\Helpers;

class UpdateStudentBroadsheetsOrStudentReportWithStudentPosition
{
    public function execute(array $data)
    {
        $totalMarkObtained = [];

        foreach ($data as $key => $datum){
            $totalMarkObtained[$key] = $datum['totalMarkObtained'];
        }

        $positions = getPosition($totalMarkObtained, 'classPosition');

        return collect($positions)->map(function ($item, $key) use ($data){

            $dataSheet = collect($data)->get($key);

            return collect($dataSheet)->put('classPosition', (string)$item['classPosition'])->toArray();

        })->toArray();
    }
}
