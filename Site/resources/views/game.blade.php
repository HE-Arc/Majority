@extends('layouts.app')

@section('content')
<link href="{{ asset('css/majority-css.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
		@if(Auth::check())
            <div class="panel panel-success">
                <div class="panel-heading">Partie</div>
				@if($data["gameStarted"])
				<div class="questionsReponses">
				<p class="question">{{$data["question"]}} ?</p>
				<table class="listReponses">
					<tr>
						<td><button type="button" id="reponse1" class="reponse">{{$data["answers"][0]->answer}}</button></td>
						<td><button type="button" id="reponse2" class="reponse">{{$data["answers"][1]->answer}}</button></td>
					</tr>
					<tr>
						<td><button type="button" id="reponse3" class="reponse">{{$data["answers"][2]->answer}}</button></td>
						<td><button type="button" id="reponse4" class="reponse">{{$data["answers"][3]->answer}}</button></td>
					</tr>
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