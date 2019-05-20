<?php

use App\Repositories\TeamRepositoryInterface;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{

    /**
     *
     * @param TeamRepositoryInterface
     */
    public function __construct(TeamRepositoryInterface $teams)
    {
        $this->teams = $teams;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                'name'  => 'Chelsea',
                'offensive_spi' => 2.4,
                'defensive_spi' => 0.5,
                'spi'   => 85.1,
            ],
            [
                'name'  => 'Arsenal',
                'offensive_spi' => 2.4,
                'defensive_spi' => 0.8,
                'spi'   => 78
            ],
            [
                'name'  => 'Manchester City',
                'offensive_spi' => 3,
                'defensive_spi' => 0.2,
                'spi'   => 94.4
            ],
            [
                'name'  => 'Liverpool',
                'offensive_spi' => 3,
                'defensive_spi' => 0.3,
                'spi'   => 93
            ]
        ];

        foreach ($teams as $team) {
            $team['pts'] = 0;
            $team['p'] = 0;
            $team['w'] = 0;
            $team['d'] = 0;
            $team['l'] = 0;
            $team['gd'] = 0;
            $this->teams->create($team);
        }
    }
}
