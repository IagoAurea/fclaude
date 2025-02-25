<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;

// Repository Interfaces
use Modules\Club\Repositories\Interfaces\ClubTypeRepositoryInterface;

class ClubTypeTableSeeder extends Seeder
{
    const TYPES = [
        'sport',
        'academic',
    ];

    /**
     * @var object
     */
    protected $clubTypeRepository;

    public function __construct(ClubTypeRepositoryInterface $clubTypeRepository) {
        $this->clubTypeRepository = $clubTypeRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::TYPES as $type) {
            $this->clubTypeRepository->create([
                'code'  =>  $type,
            ]);
        }
    }
}
