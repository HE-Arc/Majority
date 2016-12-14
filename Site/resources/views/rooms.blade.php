@extends('layouts.app')

@section('content')
<link href="{{ asset('css/majority-css.css') }}" rel="stylesheet" type="text/css" >
<!--<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>-->
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Choix des salles</div>


				@if(Auth::check())

				<form action="./createRoom">
					<button type="submit" class="btnCreateRoom">Créer une salle</button>
				</form>
				<table border="2" class="listSalles">
					<tr>
						<th>Salle</th>
						<th>Place</th>
						<th></th>
					</tr>
					@foreach($data as $game)
					<tr>
						<td>
						{{$game[0]->description}}
						</td>
						<td>
						{{$game[1]}} / {{$game[0]->max_player}}
						</td>
						<td>
						{!! Form::open(['url' => './game']) !!}
							{!! Form::hidden('gameId', $game[0]->id) !!}
							{!! Form::hidden('typeRequest', 'join') !!}
							{!! Form::hidden('idUser', Auth::id()) !!}
							{!! Form::submit('Rejoindre') !!}
						{!! Form::close() !!}
					
						</td>
					</tr>
					@endforeach
				</table>
				@endif

				@if(Auth::guest())
                <a href="./login"> Connectez-vous pour accéder à la liste des salles</a>
				@endif
            </div>
        </div>
    </div>
</div>
@endsection
