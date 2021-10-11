<?php


namespace App\Actions\Tenant\Result\Broadsheet\Helper\result;

class GetAllBroadsheetWithCaFormatAction
{
    private array $academicBroadsheet;
    private string $studentId;

    public function __construct(string $studentId = '')
    {
        $this->studentId = $studentId;
    }

    public function execute($academicBroadsheets)
    {
        $caFormats = collect( collect($academicBroadsheets)->map(function ($item){
            return collect($item->meta)->get('caFormat');
        }) )->flatten(1)->toArray();

        $broadsheet = collect(
            collect($academicBroadsheets)->map(function ($item){
                return collect( collect( collect($item->meta)->get('academicBroadsheet') )->get($this->studentId) );
            })
        );

        collect($caFormats)->map(function ($item) use ($broadsheet){
            $broadsheet->map(function ($broadsheet) use ($item){
                collect($broadsheet)->map(function ($content, $index) use($item){
                    if ($index == $item['name'] ) {
                        $this->academicBroadsheet [$this->studentId][$index] = $content;
                    }
                });
            });
        });

        return [
            'caFormats' => $caFormats,
            'academicBroadsheets' => $this->academicBroadsheet,
        ];
    }
}
