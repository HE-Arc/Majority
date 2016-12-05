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
						<th>Informations</th>
						<th>Place</th>
						<th></th>
					</tr>
					@foreach($characters as $room)
					<tr>
						<td>
						{{$room[0]}}
						</td>
						<td>
						{{$room[1]}}
						</td>
						<td>
						{{$room[2]}} / {{$room[3]}}
						</td>
						<td>
						<button type="button" >Rejoindre</button>
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