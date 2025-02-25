<?php

namespace Modules\Activity\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\Activity\Repositories\Interfaces\ActivityTypeRepositoryInterface;

class ActivityTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $activityTypeRepository;

    /**
     * Instance a new table seeder
     */
    public function __construct(ActivityTypeRepositoryInterface $activityTypeRepository)
    {
        $this->activityTypeRepository = $activityTypeRepository;
    }

    /**
     * Loop thorugh all the array of activity codes and insert them into the database
     *
     * @return void
     */
    protected function createActivities(array $elements)
    {
        foreach ($elements as $elm) {
            $this->activityTypeRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            // Club event types
            [
                'es' => [
                    'name' => 'El club ha sido creado'
                ],
                'en' => [
                    'name' => 'Club has been created'
                ],
                'code' => 'club_created'
            ],
            [
                'es' => [
                    'name' => 'El club ha sido actualizado'
                ],
                'en' => [
                    'name' => 'Club has been updated'
                ],
                'code' => 'club_updated'
            ],
            [
                'es' => [
                    'name' => 'El club ha sido borrado'
                ],
                'en' => [
                    'name' => 'Club has been deleted'
                ],
                'code' => 'club_deleted'
            ],
            // School center types
            [
                'es' => [
                    'name' => 'Centro escolar ha sido creado'
                ],
                'en' => [
                    'name' => 'School center has been created'
                ],
                'code' => 'school_center_created'
            ],
            [
                'es' => [
                    'name' => 'Centro escolar ha sido actualizado'
                ],
                'en' => [
                    'name' => 'School center has been updated'
                ],
                'code' => 'school_center_updated'
            ],
            [
                'es' => [
                    'name' => 'Centro escolar ha sido borrada'
                ],
                'en' => [
                    'name' => 'School center has been deleted'
                ],
                'code' => 'school_center_deleted'
            ],
            // Club invitation event types
            [
                'es' => [
                    'name' => 'Se ha enviado una invitación al club'
                ],
                'en' => [
                    'name' => 'A invitation to the club has been sent'
                ],
                'code' => 'club_invitation_sent'
            ],
            [
                'es' => [
                    'name' => 'La invitación al club ha sido aceptada'
                ],
                'en' => [
                    'name' => 'A invitation to the club has been accepted'
                ],
                'code' => 'club_invitation_accepted'
            ],
            // Player event types
            [
                'es' => [
                    'name' => 'Se ha creado un nuevo jugador'
                ],
                'en' => [
                    'name' => 'A new player has been created'
                ],
                'code' => 'player_created'
            ],
            [
                'es' => [
                    'name' => 'El jugador ha sido actualizado'
                ],
                'en' => [
                    'name' => 'Player has been updated'
                ],
                'code' => 'player_updated'
            ],
            [
                'es' => [
                    'name' => 'El jugador ha sido eliminado'
                ],
                'en' => [
                    'name' => 'Player has been deleted'
                ],
                'code' => 'player_deleted'
            ],
            // Competition event types
            [
                'es' => [
                    'name' => 'La competición ha sido creada'
                ],
                'en' => [
                    'name' => 'Competition has been created'
                ],
                'code' => 'competition_created'
            ],
            [
                'es' => [
                    'name' => 'La competición ha sido actualizada'
                ],
                'en' => [
                    'name' => 'Competition has been updated'
                ],
                'code' => 'competition_updated'
            ],
            [
                'es' => [
                    'name' => 'El partido de la competición ha sido creado'
                ],
                'en' => [
                    'name' => 'Competition match has been created'
                ],
                'code' => 'competition_match_created'
            ],
            [
                'es' => [
                    'name' => 'El partido de la competición ha sido actualizado'
                ],
                'en' => [
                    'name' => 'Competition match has been updated'
                ],
                'code' => 'competition_match_updated'
            ],
            [
                'es' => [
                    'name' => 'Los jugadores para el partido de la competición ha sido creado'
                ],
                'en' => [
                    'name' => 'Competition Match Player has been created'
                ],
                'code' => 'competition_match_player_created'
            ],
            [
                'es' => [
                    'name' => 'La alineación para el partido de la competición ha sido creado'
                ],
                'en' => [
                    'name' => 'Competition Match Lineup has been created'
                ],
                'code' => 'competition_match_lineup_created'
            ],
            [
                'es' => [
                    'name' => 'Los equipos rivales de la competición han sido creados'
                ],
                'en' => [
                    'name' => 'Competition Rival Teams have been created'
                ],
                'code' => 'competition_rival_team_created'
            ],
            [
                'es' => [
                    'name' => 'Los equipos rivales de la competición han sido actualizados'
                ],
                'en' => [
                    'name' => 'Competition Rival Teams have been updated'
                ],
                'code' => 'competition_rival_team_updated'
            ],
            // Psychology event types
            [
                'es' => [
                    'name' => 'El informe de psicología ha sido creado'
                ],
                'en' => [
                    'name' => 'Psychology report has been created'
                ],
                'code' => 'psychology_report_created'
            ],
            [
                'es' => [
                    'name' => 'El informe de psicología ha sido actualizado'
                ],
                'en' => [
                    'name' => 'Psychology report has been updated'
                ],
                'code' => 'psychology_report_updated'
            ],
            [
                'es' => [
                    'name' => 'El informe de psicología ha sido eliminado'
                ],
                'en' => [
                    'name' => 'Psychology report has been deleted'
                ],
                'code' => 'psychology_report_deleted'
            ],
            // Fisiotherapy event types
             [
                'es' => [
                    'name' => 'El informe de fisioterapia ha sido creado'
                ],
                'en' => [
                    'name' => 'Fisiotherapy report has been created'
                ],
                'code' => 'fisiotherapy_file_created'
            ],
            // License event types
            [
                'es' => [
                    'name' => 'Invitación enviada'
                ],
                'en' => [
                    'name' => 'Invitation sent'
                ],
                'code' => 'license_invitation_sent'
            ],
            [
                'es' => [
                    'name' => 'Invitación aceptada'
                ],
                'en' => [
                    'name' => 'Invitation accepted'
                ],
                'code' => 'license_invitation_accepted'
            ],
            [
                'es' => [
                    'name' => 'Invitación rechazada'
                ],
                'en' => [
                    'name' => 'Invitation rejected'
                ],
                'code' => 'license_invitation_rejected'
            ],
            [
                'es' => [
                    'name' => 'Licencia cancelada por el usuario'
                ],
                'en' => [
                    'name' => 'License canceled by user'
                ],
                'code' => 'license_canceled'
            ],
            [
                'es' => [
                    'name' => 'Licencia revocada por el propietario'
                ],
                'en' => [
                    'name' => 'License revoked by owner'
                ],
                'code' => 'license_revoked'
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
        $this->createActivities($this->get()->current());
    }
}
