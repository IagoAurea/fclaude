<?php

namespace Modules\Evaluation\Database\Seeders\Fixtures;

trait CompetenceFixturesTrait
{
    /**
     * * Get the list of competences to seed
     */
    private function getCompetences()
    {
        return [
            [
                'image' => public_path('images/competences/STEM.svg'),
                'es_name' => 'COMPETENCIA MATEMÁTICA Y COMPETENCIA EN CIENCIA, TECNOLOGÍA E INGENIERÍA',
                'en_name' => 'SCIENCE, TECHNOLOGY, ENGINEERING AND MATHEMATCIS COMPETENCE',
                'es_acronym' => 'STEM',
                'en_acronym' => 'STEM',
            ],
            [
                'image' => public_path('images/competences/CE.svg'),
                'es_name' => 'COMPETENCIA EMPRENDEDORA',
                'en_name' => 'ENTREPRENEURSHIP COMPETENCE',
                'es_acronym' => 'CE',
                'en_acronym' => 'CE',
            ],
            [
                'image' => public_path('images/competences/CPSAA.svg'),
                'es_name' => 'COMPETENCIA PERSONAL, SOCIAL Y DE APRENDER A APRENDER',
                'en_name' => 'PERSONAL, SOCIAL AND LEARNING TO LEARN COMPETENCE',
                'es_acronym' => 'CPSAA',
                'en_acronym' => 'CPSAA',
            ],
            [
                'image' => public_path('images/competences/CD.svg'),
                'es_name' => 'COMPETENCIA DIGITAL',
                'en_name' => 'DIGITAL COMPETENCE',
                'es_acronym' => 'CD',
                'en_acronym' => 'CD',
            ],
            [
                'image' => public_path('images/competences/CC.svg'),
                'es_name' => 'COMPETENCIA CIUDADANA',
                'en_name' => 'CITIZENSHIP COMPETENCE',
                'es_acronym' => 'CC',
                'en_acronym' => 'CC',
            ],
            [
                'image' => public_path('images/competences/CP.svg'),
                'es_name' => 'COMPETENCIA PLURILINGÜE',
                'en_name' => 'PLURILINGUAL COMPETENCE',
                'es_acronym' => 'CP',
                'en_acronym' => 'CP',
            ],
            [
                'image' => public_path('images/competences/CCEC.svg'),
                'es_name' => 'COMPETENCIA EN CONCIENCIA Y EXPRESIÓN CULTURALES',
                'en_name' => 'CULTURAL AWARENESS AND EXPRESSION COMPETENCE',
                'es_acronym' => 'CCEC',
                'en_acronym' => 'CCEC',
            ],
            [
                'image' => public_path('images/competences/CCL.svg'),
                'es_name' => 'COMPETENCIA EN COMUNICACIÓN LINGÜÍSTICA',
                'en_name' => 'LINGUISTIC COMPETENCE',
                'es_acronym' => 'CCL',
                'en_acronym' => 'CCL',
            ],
        ];
    }
}
