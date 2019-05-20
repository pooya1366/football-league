<?php

namespace App\Console\Commands;

use App\Match;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Team;
use Illuminate\Console\Command;

class GenerateMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Matches:Generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     * @param TeamRepositoryInterface $teams
     * @param MatchRepositoryInterface $matches
     * @return void
     */
    public function __construct(TeamRepositoryInterface $teams, MatchRepositoryInterface $matches)
    {
        parent::__construct();
        $this->teams = $teams;
        $this->matches = $matches;
    }


    /**
     * @param array $teams
     * @return mixed
     */
    protected function roundRobin(array $teams) {

        $away = array_splice($teams,(count($teams) / 2));
        $home = $teams;
        for ($i = 0; $i < count($home) + count($away) - 1; $i++)
        {
            for ($j=0; $j < count($home); $j++)
            {
                $round[$i][$j]['home'] = $home[$j];
                $round[$i][$j]['away'] = $away[$j];
            }
            if(count($home) + count($away) - 1 > 2)
            {
                $s = array_splice( $home, 1, 1 );
                $slice = array_shift( $s  );
                array_unshift($away,$slice );
                array_push( $home, array_pop($away ) );
            }
        }
        return $round;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $teams = $this->teams->all()->toArray();
        shuffle($teams);

        $weeks = $this->roundRobin($teams);

        foreach ($weeks as $index => $week_matches) {
            foreach ($week_matches as $_match) {
                $this->matches->create([
                    'week_number' => $index,
                    'home_team_id' => $_match['home']['_id'],
                    'home_team_name' => $_match['home']['name'],
                    'away_team_id' => $_match['away']['_id'],
                    'away_team_name' => $_match['away']['name'],
                    'done' => false
                ]);
            }
        }

        foreach ($weeks as $index => $week_matches) {
            foreach ($week_matches as $_match) {

                $this->matches->create([
                    'week_number' => ($index + count($weeks)),
                    'home_team_id' => $_match['home']['_id'],
                    'home_team_name' => $_match['home']['name'],
                    'away_team_id' => $_match['away']['_id'],
                    'away_team_name' => $_match['away']['name'],
                    'done' => false
                ]);
            }
        }
    }
}
