<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Repositories\MatchRepositoryInterface;

class MatchController extends Controller
{

    /**
     *
     * @param  MatchRepositoryInterface $matches
     * @return void
     */
    public function __construct(MatchRepositoryInterface $matches)
    {
        $this->matches = $matches;
    }

    public function get($id) {
        $match = $this->matches->get($id);
        return response()->json($match);
    }
}