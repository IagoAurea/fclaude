<?php

namespace Modules\Address\Services;

use Exception;
use App\Helpers\Helper;
use App\Traits\ResponseTrait;
use Modules\Address\Repositories\Interfaces\AddressRepositoryInterface;

class AddressService
{
    use ResponseTrait;

    /**
     * @var object
     */
    protected $addressRepository;

    /**
     * @var object
     */
    protected $helper;

    /**
     * Creates a new service instance
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        Helper $helper
    ) {
        $this->addressRepository = $addressRepository;
        $this->helper = $helper;
    }

    /**
     * Receives an address request info or array to be stored into the new table
     *
     * @param array $data
     * @return array|object|int|bool
     */
    public function store($data, $entity)
    {
        try {
            if (isset($data['phone'])) {
                $data['phone'] = $this->helper->stringArrayParser($data['phone']);
            }

            if (isset($data['mobile_phone'])) {
                $data['mobile_phone'] = $this->helper->stringArrayParser($data['mobile_phone']);
            }

            $data['entity_type'] = get_class($entity);
            $data['entity_id'] = $entity->id;

            return $this->addressRepository->create($data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates an address data depending on the entity sent
     *
     * @return bool|object
     */
    public function update($data, $entity)
    {
        try {
            $address = $this->addressRepository->findOneBy([
                'entity_type' => get_class($entity),
                'entity_id' => $entity->id
            ]);

            if (isset($data['phone'])) {
                $data['phone'] = $this->helper->stringArrayParser($data['phone']);
            }

            if (isset($data['mobile_phone'])) {
                $data['mobile_phone'] = $this->helper->stringArrayParser($data['mobile_phone']);
            }

            $data['entity_type'] = get_class($entity);
            $data['entity_id'] = $entity->id;

            if (!$address) {
                return $this->addressRepository->updateOrCreate($data);
            }

            return $this->addressRepository->update($data, $address);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
