<?php


namespace App\Repositories;


use App\Match;

class MatchRepository implements MatchRepositoryInterface
{

    public function get($match_id)
    {
        return Match::find($match_id);
    }

    /**
     * @param array
     * @return Match
     */
    public function create($match_data) {
        return Match::create($match_data);
    }

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getUnPlayedMatchesCountByWeekNumber($week_number)
    {
        return Match::where('week_number', $week_number)->where('done', false)->count();
    }

    /**
     * @return int
     */
    public function getMaxWeekNumber()
    {
        return Match::max('week_number');
    }

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getAllByWeekNumber($week_number)
    {
        return Match::where('week_number', $week_number)->get();
    }

    /**
     * @param int $week_number
     * @return int
     */
    public function getCountByWeekNumber($week_number)
    {
        return Match::where('week_number', $week_number)->count();
    }

    /**
     * @param int $week_number
     * @return mixed
     */
    public function getUnPlayedMatchesByWeekNumber($week_number)
    {
        return Match::where('week_number', $week_number)->where('done', false)->get();
    }
}