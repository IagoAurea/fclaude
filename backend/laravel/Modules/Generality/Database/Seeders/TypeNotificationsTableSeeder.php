<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Generality\Repositories\Interfaces\TypeNotificationRepositoryInterface;

class TypeNotificationsTableSeeder extends Seeder
{
    /**
     * @var $typeNotificationRepository
     */
    protected $typeNotificationRepository;

    /**
     * TypeNotificationTableSeeder constructor.
     */
    public function __construct(
        TypeNotificationRepositoryInterface $typeNotificationRepository,
    )
    {
        $this->typeNotificationRepository = $typeNotificationRepository;
    }

    /**
     * @return void
     */
    protected function createTypeNotification(array $elements)
    {
        foreach ($elements as $elm)
        {
            $this->typeNotificationRepository->create($elm);
        }
    }

     /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'code' => 'notification',
                'es' => [
                    'name' => 'Notificación',
                ],
                'en' => [
                    'name' => 'Notification',
                ]
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
        $this->createTypeNotification($this->get()->current());
    }
}
