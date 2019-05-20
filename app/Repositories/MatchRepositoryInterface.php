<?php


namespace App\Repositories;


use App\Match;

interface MatchRepositoryInterface
{

    /**
     * @param string $match_id
     * @return mixed
     */
    public function get($match_id);

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getAllByWeekNumber($week_number);

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getUnPlayedMatchesCountByWeekNumber($week_number);

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getUnPlayedMatchesByWeekNumber($week_number);

    /**
     * @return int
     */
    public function getMaxWeekNumber();

    /**
     * @param array $match_data
     * @return Match
     */
    public function create($match_data);

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getCountByWeekNumber($week_number);

}