<?php

namespace Modules\Player\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Player\Repositories\Interfaces\PunctuationRepositoryInterface;

class PunctuationTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $punctuationRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(PunctuationRepositoryInterface $punctuationRepository)
    {
        $this->punctuationRepository = $punctuationRepository;
    }

    /**
     * @return void
     */
    protected function createPunctuation(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->punctuationRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Bajo'
                ],
                'en' => [
                    'name' => 'Low'
                ],
                'code' => 'low',
                'value' => 1,
                'color' => '#ee5e60',
                'max' => 7,
                'min' => 5
            ],
            [
                'es' => [
                    'name' => 'Medio'
                ],
                'en' => [
                    'name' => 'Medium'
                ],
                'code' => 'medium',
                'value' => 2,
                'color' => '#e4eb3f',
                'max' => 11,
                'min' => 8
            ],
            [
                'es' => [
                    'name' => 'Alto'
                ],
                'en' => [
                    'name' => 'High'
                ],
                'code' => 'high',
                'value' => 3,
                'color' => '#63e882',
                'max' => 15,
                'min' => 12
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
        $this->createPunctuation($this->get()->current());
    }
}
