<?php


namespace App\Repositories;


use App\Team;

class TeamRepository implements TeamRepositoryInterface
{

    /**
     *
     * @param array
     * @return Team
     */
    public function create($team_data) {
        return Team::create($team_data);
    }

    /**
     *
     * @param string
     * @return Team
     */
    public function get($team_id)
    {
        return Team::find($team_id);
    }

    /**
     * @return Team[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function all()
    {
        return Team::all();
    }

    /**
     *
     * @param string
     * @param array
     */
    public function update($team_id, $team_data) {
        Team::find($team_id)->update($team_data);
    }

    /**
     * @return int
     */
    public function getSumPts()
    {
        return Team::sum('pts');
    }

    /**
     * @return float
     */
    public function getSumSpi()
    {
        return Team::sum('spi');
    }

    /**
     * @return mixed
     */
    public function getTeamsOrderDescByPts()
    {
        return Team::orderBy('spi', 'desc')->get();
    }
}