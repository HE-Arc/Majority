@extends('layouts.app')

@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/majority.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Créer une salle</div>
				<form action="./game">
				<div class="formCreateRoom">
					<label for="nameRoom">Nom: </label>
					<input type="text" id="nameRoom"/>
					<br>
					<b>Informations:</b><br>
					<textarea id="infoRoom", cols="100" rows="6"></textarea>
					<br>
					<label for="nbPlayerRoom">Nombre de joueurs maximum: </label>
					<input type="text" id="nbPlayerRoom"/>
					<br>
					<button type="submit">Créer</button>
				</div>
				</form> 
            </div>
        </div>
    </div>
</div>
@endsection