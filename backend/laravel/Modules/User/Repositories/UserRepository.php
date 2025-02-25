<?php

namespace Modules\User\Repositories;

use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelRepository;
use App\Traits\TranslationTrait;
use Modules\User\Entities\User;

class UserRepository extends ModelRepository implements UserRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        User $model
    ) {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function allMatchesByUser($user_id)
    {
        return $this->model
        ->with(['clubs' => function($club) {
            $club->where('club_type_id', 1)
                ->with(['teams' => function($team) {
                    $team->with(['competitions' => function($competition) {
                        $competition->with('matches');
                    }]);
                }]);
        }])
        ->where('id', $user_id)
        ->first();
    }

    /**
     * Return total matches by user
     *
     * @return integer
     */
    public function totalMatchesUser($user_id)
    {
        $matches_count = $this->model
            ->with(['clubs' => function($club) {
                $club->where('club_type_id', 1)
                    ->with(['teams' => function($team) {
                        $team->with(['competitions' => function($competition) {
                            $competition->withCount('matches');
                        }]);
                    }]);
            }])
            ->where('id', $user_id)
            ->first();

        return $matches_count->clubs->sum(function($club) {
            return $club->teams->sum(function($team) {
                return $team->competitions->sum('matches_count');
            });
        });
    }
    /**
     * Return total players by user
     *
     * @return integer
     */
    public function totalPlayersUser($user_id)
    {
        $players_count = $this->model
            ->with(['clubs' => function($club) {
                $club->where('club_type_id', 1)
                    ->with(['teams' => function($team) {
                        $team->withCount('players');
                    }]);
            }])
            ->where('id', $user_id)
            ->first();

        return $players_count->clubs->sum(function($club) {
            return $club->teams->sum(function($team) {
                return $team->players->count();
            });
        });
    }

    /**
     * @return array Returns an array of gender
     */
    public function getGenderTypes()
    {
        $genders = User::getGenderTypes();

        array_walk($genders, function(&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $genders;
    }

    /**
     * @return array Returns an array of gender identity
     */
    public function getGenderIdentityTypes()
    {
        $genders_identity = User::getGenderIdentityTypes();

        array_walk($genders_identity, function(&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $genders_identity;
    }

    /**
     * @param int $id
     * @return object Returns an user
     */
    public function getUser($id)
    {
        return $this->model->with('image')->with('cover')->find($id);
    }

    /**
     * @param string $email
     * @return object Returns an user
     */
    public function getUserByEmail($email)
    {
        return $this->model
                ->with('image')
                ->with('cover')
                ->where('email',$email)
                ->first();
    }

    /**
 * Get all users
 *
 * @return \Illuminate\Database\Eloquent\Collection
 */
public function getAllUsers()
{
    return $this->model->all();
}
}
