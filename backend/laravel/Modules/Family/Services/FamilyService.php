<?php

namespace Modules\Family\Services;

use App\Traits\ResponseTrait;

// Repositories
use Modules\Family\Repositories\Interfaces\FamilyRepositoryInterface;
use Modules\Family\Repositories\Interfaces\FamilyMemberRepositoryInterface;
use Modules\Family\Repositories\Interfaces\FamilyMemberTypeRepositoryInterface;
use Modules\Family\Repositories\Interfaces\FamilyEntityMemberRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Helpers\Helper;
use Exception;

class FamilyService 
{
    use ResponseTrait;

    /**
     * @var object
     */
    protected $familyRepository;

    /**
     * @var object
     */
    protected $familyMemberRepository;

    /**
     * @var object
     */
    protected $familyMemberTypeRepository;

    /**
     * @var object
     */
    protected $familyEntityMemberTypeRepository;

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $helper;

    /**
     * Instances a new Service class
     */
    public function __construct(
        FamilyRepositoryInterface $familyRepository,
        FamilyMemberRepositoryInterface $familyMemberRepository,
        FamilyMemberTypeRepositoryInterface $familyMemberTypeRepository,
        FamilyEntityMemberRepositoryInterface $familyEntityMemberTypeRepository,
        UserRepositoryInterface $userRepository,
        Helper $helper
    ) {
        $this->familyRepository = $familyRepository;
        $this->familyMemberRepository = $familyMemberRepository;
        $this->familyMemberTypeRepository = $familyMemberTypeRepository;
        $this->familyEntityMemberTypeRepository = $familyEntityMemberTypeRepository;
        $this->userRepository = $userRepository;
        $this->helper = $helper;
    }

    /**
     * Stores a new family member item
     * 
     * @return object|bool
     */
    public function manageMember($family, $data, $type)
    {
        if (!isset($data['email'])) {
            return NULL;
        }

        try {
            $emailCondition = [
                'email' => $data['email'],
            ];

            $existent = $this->userRepository->findOneBy($emailCondition);

            // Save it to the $user var, in case it doesn't, just create
            // a new registry using the email
            $user = $existent ?? $this->userRepository->create(
                $emailCondition
            );

            // Save the user_id into the updating/inserting data
            $data['user_id'] = $user->id;

            $type = $this->familyMemberTypeRepository->findOneBy([
                'code' => $type
            ]);
            
            $data['family_member_type_id'] = $type->id;

            // Check if there's an already existing member with the related email
            $existentMember = $this->familyMemberRepository->findOneBy(
                $emailCondition
            );

            if (isset($data['phone'])) {
                $data['phone'] = $this->helper->stringArrayParser($data['phone']);
            }

            if (isset($data['mobile_phone'])) {
                $data['mobile_phone'] = $this->helper->stringArrayParser($data['mobile_phone']);
            }

            // In case there's no an existent member, create it, otherwise
            // just update the existing item
            $member = !$existentMember
                ? $this->familyMemberRepository->create($data)
                : $this->familyMemberRepository->update($data, $existentMember);

            // If it's null, add the item to the entity
            if (!$existentMember) {
                $this->familyEntityMemberTypeRepository->create([
                    'family_id' => $family->id,
                    'family_member_id' => $member->id,
                ]);
            }

            // When updates, the update method returns a true boolean, check if it's different
            // in order to return the updated one
            return $member !== true ? $member : $existentMember;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Stores a family set of information
     * 
     * @return object|bool
     */
    public function store($statusId, $entity)
    {
        try {
            $data = [
                'entity_type' => get_class($entity),
                'entity_id' => $entity->id,
                'parents_marital_status_id' => $statusId,
            ];

            return $this->familyRepository->create($data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
    
    /**
     * Update a family set of information
     * 
     * @return object|bool
     */
    public function update($statusId, $entity)
    {
        try {
            $data = [
                'entity_type' => get_class($entity),
                'entity_id' => $entity->id,
            ];

            return $this->familyRepository->update([
                'parents_marital_status_id' => $statusId
            ], $data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
