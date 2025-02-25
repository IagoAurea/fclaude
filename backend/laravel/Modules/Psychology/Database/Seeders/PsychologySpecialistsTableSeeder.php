<?php

namespace Modules\Psychology\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Psychology\Repositories\Interfaces\PsychologySpecialistRepositoryInterface;

class PsychologySpecialistsTableSeeder extends Seeder
{
    /**
     * Repository
     * @var $psychologySpecialistRepository
     */
    protected $psychologySpecialistRepository;

    /**
     * PsychologySpecialistsTableSeeder constructor.
     * @param PsychologySpecialistRepositoryInterface $psychologySpecialistRepository
     */
    public function __construct(PsychologySpecialistRepositoryInterface $psychologySpecialistRepository)
    {
        $this->psychologySpecialistRepository = $psychologySpecialistRepository;
    }

    /**
     * Method create psychologySpecialists
     * @param array $elements
     * @return void
     */
    protected function createPsychologySpecialists(array $elements)
    {
        foreach ($elements as $element)
        {
            $this->psychologySpecialistRepository->create($element);
        }
    }

    /**
     * @return \Generator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Psiquiatra'
                ],
                'en' => [
                    'name' => 'Psychiatrist'
                ],
                'code' => 'psychiatrist'
            ],
            [
                'es' => [
                    'name' => 'Neurólogo'
                ],
                'en' => [
                    'name' => 'Neurologist'
                ],
                'code' => 'neurologist'
            ],
            [
                'es' => [
                    'name' => 'Otros'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other'
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPsychologySpecialists($this->get()->current());
    }
}
