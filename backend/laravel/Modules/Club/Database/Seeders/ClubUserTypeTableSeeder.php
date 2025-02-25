<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;

// Repository Interfaces
use Modules\Club\Repositories\Interfaces\ClubUserTypeRepositoryInterface;

class ClubUserTypeTableSeeder extends Seeder
{

    const TYPES = [
        'staff', 'member'
    ];

    /**
     * @var object
     */
    protected $clubUserTypeRepository;

    public function __construct(ClubUserTypeRepositoryInterface $clubUserTypeRepository) {
        $this->clubUserTypeRepository = $clubUserTypeRepository;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::TYPES as $type) {
            $this->clubUserTypeRepository->create([
                'name'  =>  $type,
                'title' =>  ucfirst($type)
            ]);
        }
    }
}
