<?php


namespace App;


class Match extends \Moloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['week_number', 'home_team_id', 'home_team_name', 'away_team_id', 'away_team_name', 'done'];
}