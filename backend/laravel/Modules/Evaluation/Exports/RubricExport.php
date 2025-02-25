<?php

namespace Modules\Evaluation\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class RubricExport implements FromCollection, WithMapping
{
    const RUBRIC_DATA = '###rubric_data###';
    const RUBRIC_INDICATORS = '###rubric_indicators###';
    const EMPTY = '###empty###';

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function collection()
    {
        return $this->payload;
    }

    public function map($rubric): array
    {
        return [
            [
                self::RUBRIC_DATA
            ],
            [
                $rubric->name,
                $rubric->created_at,
                $rubric->updated_at,
                $this->mapClassrooms($rubric)
            ],
            [
                self::RUBRIC_INDICATORS
            ],
            ...$this->mapIndicators($rubric)
        ];
    }

    private function mapIndicators($payload)
    {
        return $payload->indicators->map(function ($item) {
            return [
                $item->id,
                $item->name,
                $item->percentage,
                $item->evaluation_criteria ? $item->evaluation_criteria : self::EMPTY,
                $item->insufficient_caption ? $item->insufficient_caption : self::EMPTY,
                $item->sufficient_caption ? $item->sufficient_caption : self::EMPTY,
                $item->remarkable_caption ? $item->remarkable_caption : self::EMPTY,
                $item->outstanding_caption ? $item->outstanding_caption : self::EMPTY,
                $item->created_at,
                $item->updated_at,
                $this->mapCompetences($item),
            ];
        });
    }

    private function mapClassrooms($payload)
    {
        return implode('-', $payload->classrooms->map->id->toArray());
    }

    private function mapCompetences($payload)
    {
        return implode('-', $payload->competences->map->id->toArray());
    }
}
