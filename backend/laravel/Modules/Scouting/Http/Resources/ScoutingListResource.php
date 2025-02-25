<?php

namespace Modules\Scouting\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScoutingListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'match_id' => $this->id,
            'competition_name' => $this->competition_name,
            'competition_rival_team' => $this->competitionRivalTeam,
            'team' => $this->competition->team,
            'players' => isset($this->players) ? $this->players : null,
            'start_at' => $this->start_at,
            'finish_date' => isset($this->scouting) ? $this->scouting->finish_date : null,
            'match_situation' => $this->match_situation,
            'scouting_status' => isset($this->scouting) ? $this->scouting->status : null,
            'scouting_id' => isset($this->scouting) ? $this->scouting->id : null
        ];
    }
}
