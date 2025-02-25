<?php

namespace Modules\Generality\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\SplashRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class SplashTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var $splashRepository
     */
    protected $splashRepository;

    
    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * SplashTableSeeder constructor.
     */
    public function __construct(
        SplashRepositoryInterface $splashRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->splashRepository = $splashRepository;
        $this->resourceRepository = $resourceRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createSplash(array $elements)
    {
        foreach ($elements as $elm)
        {
            $params['directory'] = "splashs";
            $params['name'] = $elm['image'];
            $image = $this->getImage($params);

            $dataResource = $this->uploadResource('/splashs', $image);

            $resource = $this->resourceRepository->create($dataResource);

            $elm['image_id'] = $resource->id;

            unset($elm['image']);

            $this->splashRepository->create($elm);
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
                    'name' => '¡Hola, soy Fi! ¡Bienvenido a fisicalcoach!',
                    'description' => 'Comienza tu experiencia y crece como profesional con el primer software que integra todas las áreas del trabajo deportivo.'
                ],
                'en' => [
                    'name' => 'Hi, I\'m Fi! Welcome to fisicalcoach!',
                    'description' => 'Begin your experience and grow as a professional with the first software that integrates all areas of sports workout.'
                ],
                'image' => 'splash_1',
                'active' => true
            ],
            [
                'es' => [
                    'name' => 'Manual de usuario',
                    'description' =>'¡Recuerda! Si tienes dudas no te preocupes, te ayudaré a conocer la herramienta a través de nuestra guía de usuario.',
                    'text_url' => 'Accede desde el botón Ayuda'
                ],
                'en' => [
                    'name' => 'User Manual',
                    'description' =>'Remember! If you have any doubts, don\'t worry, I\'ll help you get to know this software toll through our user guide.',
                    'text_url' => 'Access from the help button'
                ],
                'url'=> 'https://fisicalcoach.com/',
                'image' => 'splash_2',
                'active' => true
            ],
            [
                'es' => [
                    'name' => '¡Planes fisicalcoach!',
                    'description' =>'Nos adaptamos a tus necesidades e intereses como profesional.'
                ],
                'en' => [
                    'name' => 'Fisicalcoach plans!',
                    'description' =>'We adapt to your needs and interests as a professional.'
                ],
                'image' => 'splash_3',
                'active' => true
            ],
            [
                'es' => [
                    'name' => '¡Descubre la Realidad Virtual!',
                    'description' =>'Disfruta de una experiencia única y vive tus ejercicios como si estuvieras en el terreno de juego.'
                ],
                'en' => [
                    'name' => 'Discover Virtual Reality!',
                    'description' =>'Enjoy a unique experience and live your exercises as if you were on the pitch.'
                ],
                'image' => 'splash_4',
                'active' => true
            ],
            [
                'es' => [
                    'name' => '¡Hola soy Fi!, ¡Bienvenido a fisicalcoach!',
                    'description' => ''
                ],
                'en' => [
                    'name' => 'Hi, I\'m Fi, welcome to fisicalcoach!',
                    'description' => ''
                ],
                'image' => 'splash_ext1',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext2',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext3',
                'active' => true,
                'external' => true
            ],   
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext4',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext5',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext6',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext7',
                'active' => true,
                'external' => true
            ],  
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext8',
                'active' => true,
                'external' => true
            ],    
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext9',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext10',
                'active' => true,
                'external' => true
            ],
            [
                'es' => [
                    'name' =>'',
                    'description' =>''
                ],
                'en' => [
                    'name' =>'',
                    'description' =>''
                ],
                'image' => 'splash_ext11',
                'active' => true,
                'external' => true
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSplash($this->get()->current());
    }
}
