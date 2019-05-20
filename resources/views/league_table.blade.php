<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <style>
        .table tr  {
            background-color: white;
        }
    </style>
    <title>Premier League</title>
</head>
<body>
<div class="modal" tabindex="-1" role="dialog" id="editMatchModal">
    <div class="modal-dialog" role="document">
        <form method="POST" id="updateScoresForm" action="/matches">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Match Scores</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="homeTeamGoals" class="home-team-label"></label>
                        <input type="number" class="form-control" name='home_team_goals' id="homeTeamGoals">
                    </div>
                    <div class="form-group">
                        <label for="awayTeamGoals" class="away-team-label"></label>
                        <input type="number" class="form-control" name='away_team_goals' id="awayTeamGoals">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container-fluid">
    <div class="jumbotron">
        <div class="row">
            <div class="col">
                <h2 class="text-center">League Table</h2>
                <hr/>
                <table class="table teams-table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Teams</th>
                        <th scope="col">PTS</th>
                        <th scope="col">P</th>
                        <th scope="col">W</th>
                        <th scope="col">D</th>
                        <th scope="col">L</th>
                        <th scope="col">GD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teams as $team)
                        <tr>
                            <th scope="row">{{ $team->name }}</th>
                            <td>{{ $team->pts }}</td>
                            <td>{{ $team->p }}</td>
                            <td>{{ $team->w }}</td>
                            <td>{{ $team->d }}</td>
                            <td>{{ $team->l }}</td>
                            <td>{{ $team->gd }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col">
                <h2 class="text-center">Match Results</h2>
                <hr/>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" colspan="7">{{ $week_number_ordinal }} Week Match Result</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td>{{ $match->home_team_name }}</td>
                                <td class="text-right">
                                    @if($match->done)
                                        {{ $match->home_team_goals }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-left">
                                    @if($match->done)
                                        {{ $match->away_team_goals }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right">{{ $match->away_team_name }}</td>
                                <td class="text-right">
                                    <a href="#" data-match-id="{{ $match->id }}" class="edit-match-btn btn btn-light btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h2 class="text-center">Prediction</h2>
                <hr/>
                <table class="table">
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <th>{{ $team->name }}</th>
                                <td>{{ $team->win_score }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col">
                @if($has_un_played_match)
                    <a href="{{ url('play-all', ['week_number' => $week_number]) }}" class="btn btn-warning">Play All</a>
                @endif
            </div>

                <div class="col text-right">
                    @if($has_prev_week)
                        <a href="{{ url('weeks', ['week_number' => $week_number - 1]) }}" class="btn btn-secondary">< Previous Week</a>
                    @endif
                    @if($has_next_week)
                        <a href="{{ url('weeks', ['week_number' => $week_number + 1]) }}" class="btn btn-primary">Next Week ></a>
                    @endif
                </div>

        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    $('.edit-match-btn').click(function(e) {
        e.preventDefault();
        var matchId = $(this).data('match-id');
        $.get( "/api/matches/" + matchId, function( data ) {
            $('#editMatchModal').modal();
            $('#updateScoresForm').attr('action', '/matches/' + matchId);
            $('#editMatchModal .home-team-label').html(data.home_team_name);
            $('#editMatchModal .away-team-label').html(data.away_team_name);
            if(data.done) {
                $('#homeTeamGoals').val(data.home_team_goals);
                $('#awayTeamGoals').val(data.away_team_goals)
            }
        });
    })
</script>
</body>
</html>