<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use NumberFormatter;

class MatchController extends Controller
{
    /**
     *
     * @param TeamRepositoryInterface $teams
     * @param  MatchRepositoryInterface $matches
     * @return void
     */
    public function __construct(TeamRepositoryInterface $teams, MatchRepositoryInterface $matches)
    {
        $this->teams = $teams;
        $this->matches = $matches;
    }

    public function index($week_number = 0) {

        $week_number = (int) $week_number;

        $matches = $this->matches->getAllByWeekNumber($week_number);

        $has_un_played_match =  $this->matches->getUnPlayedMatchesCountByWeekNumber($week_number) > 0 ;

        $total_weeks_count = $this->matches->getMaxWeekNumber();

        if(!count($matches)) {
            abort(404);
        }

        $teams = $this->teams->getTeamsOrderDescByPts();

        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);

        return view('league_table')
            ->with('matches', $matches)
            ->with('teams', $teams)
            ->with('teams', $teams)
            ->with('week_number', $week_number)
            ->with('week_number_ordinal', $numberFormatter->format($week_number + 1))
            ->with('has_next_week', $week_number < $total_weeks_count)
            ->with('has_prev_week', $week_number > 0)
            ->with('has_un_played_match', $has_un_played_match);
    }

    public function playAll($week_number) {
        $week_number = (int) $week_number;

        if(!$this->matches->getCountByWeekNumber($week_number)) {
            abort(404);
        }

        $matches = $this->matches->getUnPlayedMatchesByWeekNumber($week_number);

        if(!count($matches)) {
            return redirect()
                ->back()
                ->withErrors(['matches', 'All matches are played in this week']);
        }

        foreach ($matches as $match) {

            $home_team = $this->teams->get($match->home_team_id);
            $away_team = $this->teams->get($match->away_team_id);

            $home_team_goals = 0;
            $away_team_goals = 0;

            if($home_team && $away_team) {
                $home_team_spi = ($home_team->offensive_spi + $away_team->defensive_spi) / 2;
                $away_team_spi = ($away_team->offensive_spi + $home_team->defensive_spi) / 2;

                if($home_team_spi > $away_team_spi) {
                    $away_team_goals = mt_rand(0, round($away_team_spi));
                    $min = $away_team_goals > 0 ? $away_team_goals : 1;
                    $home_team_goals = mt_rand($min, $min * round($home_team_spi));
                } else {
                    $home_team_goals = mt_rand(0, round($home_team_spi));
                    $min = $home_team_goals > 0 ? $home_team_goals : 1;
                    $away_team_goals = mt_rand($min, $min * round($away_team_spi));
                }
            }

            $match->home_team_goals = $home_team_goals;
            $match->away_team_goals = $away_team_goals;

            if($match->home_team_goals > $match->away_team_goals) {
                $winner_team_id = $match->home_team_id;
                $looser_team_id = $match->away_team_id;
            }  else if($match->away_team_goals > $match->home_team_goals) {
                $winner_team_id = $match->away_team_id;
                $looser_team_id = $match->home_team_id;
            } else {
                $winner_team_id = null;
                $looser_team_id = null;
            }

            $match->done = true;
            $match->winner_team_id = $winner_team_id;
            $match->looser_team_id = $looser_team_id;
            $match->save();

        }
        return redirect()
            ->back();
    }

    public function update($id, Request $request) {
        $match = $this->matches->get($id);

        if($match) {
            $request->validate([
                'home_team_goals' => 'required|int',
                'away_team_goals' => 'required|int',
            ]);

            $match->home_team_goals = (int) $request->input('home_team_goals');
            $match->away_team_goals = (int) $request->input('away_team_goals');

            if($match->home_team_goals > $match->away_team_goals) {
                $winner_team_id = $match->home_team_id;
                $looser_team_id = $match->away_team_id;
            }  else if($match->away_team_goals > $match->home_team_goals) {
                $winner_team_id = $match->away_team_id;
                $looser_team_id = $match->home_team_id;
            } else {
                $winner_team_id = null;
                $looser_team_id = null;
            }

            $match->done = true;
            $match->winner_team_id = $winner_team_id;
            $match->looser_team_id = $looser_team_id;
            $match->save();

            return redirect('weeks/' . $match->week_number);
        }

        return redirect()->back();

    }
}