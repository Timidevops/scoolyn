<?php


namespace App\Actions\Tenant\Result\ContinuousAssessment;


class FilterFormInputAction
{
    public function execute(array $input): array
    {
        $format = [];

        for($i = 0; $i< $input['numberOfCA']; $i++){
            $format []= [
                'name'  => $input['caName'][$i],
                'score' => $input['caScore'][$i],
            ];
        }

        return $format;
    }
}
