<?php

namespace Modules\Evaluation\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Modules\Evaluation\Entities\Indicator;
use Modules\Evaluation\Entities\Rubric;
use Modules\Evaluation\Exceptions\RubricPayloadDataIsWrongFormattedException;
use Modules\Evaluation\Exports\RubricExport;

class RubricsImport implements ToArray
{
    /**
     * @param  array  $payload
     */
    public function array(array $payload)
    {
        $rubric = $this->importRubric($payload);
        $this->importIndicators($payload, $rubric);
    }

    /**
     * Import the rubric
     * 
     * @param  array  $payload
     */
    private function importRubric($payload)
    {
        if ($payload[0][0] != RubricExport::RUBRIC_DATA) {
            throw new RubricPayloadDataIsWrongFormattedException;
        }
        $row = $payload[1];

        $rubric = Rubric::create([
            'name'           => $row[0],
            'created_at'     => $row[1],
            'updated_at'     => $row[2],
        ]);

        $classrooms = explode('-', $row[3]);

        $rubric->classrooms()->sync($classrooms);

        return $rubric;
    }

    /**
     * Import the indicators and attacht them to a rubric
     * 
     * @param  array  $payload
     * @param  Rubric  $rubric
     */
    private function importIndicators($payload, $rubric)
    {
        if ($payload[2][0] != RubricExport::RUBRIC_INDICATORS) {
            throw new RubricPayloadDataIsWrongFormattedException;
        }

        $indicators = array_slice($payload, 3);

        foreach ($indicators as $row) {
            $indicator = Indicator::create([
                'name' => $row[1],
                'percentage' => $row[2],
                'evaluation_criteria' => $row[3] != RubricExport::EMPTY ? $row[3] : '',
                'insufficient_caption' => $row[4] != RubricExport::EMPTY ? $row[4] : '',
                'sufficient_caption' => $row[5] != RubricExport::EMPTY ? $row[5] : '',
                'remarkable_caption' => $row[6] != RubricExport::EMPTY ? $row[6] : '',
                'outstanding_caption' => $row[7] != RubricExport::EMPTY ? $row[7] : '',
                'created_at' => $row[8],
                'updated_at' => $row[9],
            ]);

            $competences = explode('-', $row[10]);
            $indicator->competences()->sync($competences);
            $rubric->indicators()->attach($indicator->id);
        }
    }
}
