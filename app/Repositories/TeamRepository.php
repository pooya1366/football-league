<?php


namespace App\Repositories;


use App\Match;
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
        return Team::orderBy('pts', 'desc')->get();
    }

    public function getDrawnCounts($team_id)
    {
        return Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->where('winner_team_id', null)
            ->count();
    }

    public function getGoalsConcededCount($team_id)
    {
        return Match::where('done', true)->where('home_team_id', $team_id)->sum('away_team_goals') +
            Match::where('done')->where('away_team_id', $team_id)->sum('home_team_goals');
    }

    public function getGoalsCount($team_id)
    {
        return Match::where('done', true)->where('home_team_id', $team_id)->sum('home_team_goals') +
            Match::where('done')->where('away_team_id', $team_id)->sum('away_team_goals');
    }

    public function getLosesCount($team_id)
    {
        return Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->where('looser_team_id', $team_id)
            ->count();
    }

    public function getMatchesPlayedCount($team_id)
    {
        return  Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->count();
    }
    public function getWinsCount($team_id)
    {
        return Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->where('winner_team_id', $team_id)
            ->count();
    }
}