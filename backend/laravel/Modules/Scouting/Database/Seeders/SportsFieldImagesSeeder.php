<?php

namespace Modules\Scouting\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;

class SportsFieldImagesSeeder extends BaseSeeder
{
    /**
     * @var object
     */
    protected $sportRepository;

    public function __construct(SportRepositoryInterface $sportRepository)
    {
        $this->sportRepository = $sportRepository;
    }

    /**
     * @return void
     */
    protected function createSports(array $sports)
    {
        foreach($sports as $sport => $image) 
        {
            $this->sportRepository->updateFieldImage($sport, $image);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        $randomImage = $this->getImageRandom('rand');

        yield [
                'football' => $randomImage,
                'basketball' => $randomImage,
                'handball' => $randomImage,
                'indoor_soccer' => $randomImage,
                'volleyball' => $randomImage,
                'beach_volleyball' => $randomImage,
                'badminton' => $randomImage,
                'tennis' => $randomImage,
                'padel' => $randomImage,
                'roller_hockey' => $randomImage,
                'field_hockey' => $randomImage,
                'ice_hockey' => $randomImage,
                'rugby' => $randomImage,
                'baseball' => $randomImage,
                'cricket' => $randomImage,
                'swimming' => $randomImage,
                'waterpolo' => $randomImage,
                'american_soccer' => $randomImage
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSports($this->get()->current());
    }
}
