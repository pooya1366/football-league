<?php

namespace App\Observers;

use App\Match;
use App\Repositories\TeamRepositoryInterface;
use App\Team;

class MatchObserver
{

    /**
     * MatchObserver constructor.
     * @param TeamRepositoryInterface $teams
     */
    public function __construct(TeamRepositoryInterface $teams)
    {
        $this->teams = $teams;
    }

    /**
     * Handle the match "created" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function created(Match $match)
    {
        //
    }

    /**
     * Handle the match "updated" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function updated(Match $match)
    {
        $this->updateTeamStatistics($match->home_team_id);
        $this->updateTeamStatistics($match->away_team_id);
    }

    /**
     * Handle the match "deleted" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function deleted(Match $match)
    {
        //
    }

    /**
     * Handle the match "restored" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function restored(Match $match)
    {
        //
    }

    /**
     * Handle the match "force deleted" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function forceDeleted(Match $match)
    {
        //
    }

    private function updateTeamStatistics($team_id)
    {
        $played_counts = $this->teams->getMatchesPlayedCount($team_id);

        $wins_count = $this->teams->getWinsCount($team_id);

        $drawn_count = $this->teams->getDrawnCounts($team_id);

        $loses_count = $this->teams->getLosesCount($team_id);

        $goals = $this->teams->getGoalsCount($team_id);

        $goals_conceded = $this->teams->getGoalsConcededCount($team_id);

        Team::where('_id', $team_id)
            ->update([
                'pts' => ($wins_count * 3) + $drawn_count,
                'p' => $played_counts,
                'w' => $wins_count,
                'd' => $drawn_count,
                'l' => $loses_count,
                'gd' => $goals - $goals_conceded
            ]);
    }
}
