<?php

namespace App\Observers;

use App\Match;
use App\Team;

class MatchObserver
{
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
        /*$team = Team::find($team_id);

        if($team) {
            $team->p = $team->getMatchesPlayedCount();
            $team->w = $team->getHomeWinsCount() + $team->getAwayWinsCount();
            $team->d = $team->getDrawnCount();
            $team->l = $team->getHomeLoseCount() + $team->getAwayLoseCount();
            $team->gd = $team->getHomeGoalsCount() + $team->getAwayGoalsCount() -
                $team->getHomeGoalsConcededCount() - $team->getAwayGoalsConcededCount();
            $team->save();
        }*/

        $played_counts = Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->count();

        $wins_count = Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->where('winner_team_id', $team_id)
            ->count();

        $drawn_count = Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->where('winner_team_id', null)
            ->count();

        $loss_count = Match::where(function($query) use($team_id) {
            $query->where('home_team_id', $team_id)
                ->orWhere('away_team_id', $team_id);
        })->where('done', true)
            ->where('looser_team_id', $team_id)
            ->count();

        $goals = Match::where('done', true)->where('home_team_id', $team_id)->sum('home_team_goals') +
            Match::where('done')->where('away_team_id', $team_id)->sum('away_team_goals');


        $goals_conceded = Match::where('done', true)->where('home_team_id', $team_id)->sum('away_team_goals') +
            Match::where('done')->where('away_team_id', $team_id)->sum('home_team_goals');

        Team::where('_id', $team_id)
            ->update([
                'pts' => ($wins_count * 3) + $drawn_count,
                'p' => $played_counts,
                'w' => $wins_count,
                'd' => $drawn_count,
                'l' => $loss_count,
                'gd' => $goals - $goals_conceded
            ]);
    }
}
