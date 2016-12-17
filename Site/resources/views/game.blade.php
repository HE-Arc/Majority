@extends('layouts.app')

@section('content')
<link href="{{ asset('css/majority-css.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
		@if(Auth::check())
            <div class="panel panel-success">
                <div class="panel-heading">Round {{$data["nRound"]}}</div>
				@if($data["gameStarted"])
				<div class="questionsReponses">
				<p class="question">{{$data["question"]}}</p>
				<p class="question">Secondes restantes avant le prochain round: {{$data["remainingTime"]}}</p>
				<table class="listReponses">
					<tr>
						<td>{!! Form::open(['url' => './game']) !!}
							{!! Form::hidden('typeRequest', 'answer') !!}
							{!! Form::hidden('idUser', Auth::id()) !!}
							{!! Form::hidden('idAnswer', $data["answers"][0]->id) !!}
							{!! Form::hidden('gameId', $data["gameId"]) !!}
							{!! Form::submit($data["answers"][0]->answer, ['id' => 'reponse1', 'class' => 'reponse']) !!}
						{!! Form::close() !!}</td>
						<td>{!! Form::open(['url' => './game']) !!}
							{!! Form::hidden('typeRequest', 'answer') !!}
							{!! Form::hidden('idUser', Auth::id()) !!}
							{!! Form::hidden('idAnswer', $data["answers"][1]->id) !!}
							{!! Form::hidden('gameId', $data["gameId"]) !!}
							{!! Form::submit($data["answers"][1]->answer, ['id' => 'reponse2', 'class' => 'reponse']) !!}
						{!! Form::close() !!}</td>
					</tr>
					<tr>
						<td>{!! Form::open(['url' => './game']) !!}
							{!! Form::hidden('typeRequest', 'answer') !!}
							{!! Form::hidden('idUser', Auth::id()) !!}
							{!! Form::hidden('idAnswer', $data["answers"][2]->id) !!}
							{!! Form::hidden('gameId', $data["gameId"]) !!}
							{!! Form::submit($data["answers"][2]->answer, ['id' => 'reponse3', 'class' => 'reponse']) !!}
						{!! Form::close() !!}</td>
						<td>{!! Form::open(['url' => './game']) !!}
							{!! Form::hidden('typeRequest', 'answer') !!}
							{!! Form::hidden('idUser', Auth::id()) !!}
							{!! Form::hidden('idAnswer', $data["answers"][3]->id) !!}
							{!! Form::hidden('gameId', $data["gameId"]) !!}
							{!! Form::submit($data["answers"][3]->answer, ['id' => 'reponse4', 'class' => 'reponse']) !!}
						{!! Form::close() !!}</td>
					</tr>

                    @if(Auth::id() == $data["owner"])
                    <tr>
                        <td colspan="2">
                            {!! Form::open(['url' => './game']) !!}
                            {!! Form::hidden('typeRequest', 'timeout') !!}
                            {!! Form::hidden('idUser', Auth::id()) !!}
                            {!! Form::hidden('gameId', $data["gameId"]) !!}
                            {!! Form::submit('Fin du round', ['class' => 'question']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endif
				</table>



				</div>
				<div class="joueurs">
					<table border="2" class="listPlayer">
					@foreach($data["players"] as $player => $playerData)
					<tr>
						@if($playerData[0] == 0)
						<td class="eliminatedPlayer">
						{{$player}}
						</td>
						@else
						<td class="chooseAnswer{{$playerData[1]}}">
						{{$player}}
						</td>
						@endif
					</tr>
					@endforeach
				</table>
				</div>
				@else
				<div class="test">
				<p>Le jeu n'a pas commencé</p>
				</div>
				@endif
            </div>
			@endif

			@if(Auth::guest())
            <a href="./login"> Connectez-vous pour jouer</a>
			@endif
        </div>
    </div>
</div>
@endsection
