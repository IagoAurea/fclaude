<?php

namespace Modules\Team\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Team\Repositories\Interfaces\TeamTypeRepositoryInterface;

class TeamsTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $teamTypeRepository;

    public function __construct(TeamTypeRepositoryInterface $teamTypeRepository)
    {
        $this->teamTypeRepository = $teamTypeRepository;
    }

    /**
     * @return void
     */
    protected function createTeamType(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->teamTypeRepository->create($elm);
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
                    'name' => 'Amateur'
                ],
                'en' => [
                    'name' => 'Amateur'
                ],
                'code' => 'amateur'
            ],
            [
                'es' => [
                    'name' => 'Profesional'
                ],
                'en' => [
                    'name' => 'Professional'
                ],
                'code' => 'professional'
            ],
            [
                'es' => [
                    'name' => 'Academia'
                ],
                'en' => [
                    'name' => 'Academy'
                ],
                'code' => 'academy'
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
        $this->createTeamType($this->get()->current());
    }
}
