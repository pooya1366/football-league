<?php


namespace App;

class Team extends \Moloquent
{
    protected $appends = ['win_score'];


    public function getWinScoreAttribute() {

        $total_spi = Team::sum('spi');
        $total_pts = Team::sum('pts');

        if($total_pts > 0) {
            $_score = $this->spi / $total_spi * 50;
            $_score2 = $this->pts / $total_pts * 50;
        } else {
            $_score = $this->spi / $total_spi * 100;
            $_score2 = 0;
        }
        return $_score + $_score2;
    }
}