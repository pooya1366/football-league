<?php


namespace App\Repositories;


use App\Team;

interface TeamRepositoryInterface
{

    /**
     * @param array $team_data
     * @return mixed
     */
    public function create($team_data);

    /**
     * @param string $team_id
     * @return mixed
     */
    public function get($team_id);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @return mixed
     */
    public function getTeamsOrderDescByPts();

    /**
     * @return mixed
     */
    public function getSumSpi();

    /**
     * @return mixed
     */
    public function getSumPts();

    /**
     * @param string $team_id
     * @param array $post_data
     * @return mixed
     */
    public function update($team_id, $post_data);

    /**
     * @param $team_id
     * @return int
     */
    public function getMatchesPlayedCount($team_id);

    /**
     * @param $team_id
     * @return int
     */
    public function getWinsCount($team_id);

    /**
     * @param $team_id
     * @return int
     */
    public function getDrawnCounts($team_id);

    /**
     * @param $team_id
     * @return mixed
     */
    public function getLosesCount($team_id);

    /**
     * @param $team_id
     * @return int
     */
    public function getGoalsCount($team_id);

    /**
     * @param $team_id
     * @return int
     */
    public function getGoalsConcededCount($team_id);
}