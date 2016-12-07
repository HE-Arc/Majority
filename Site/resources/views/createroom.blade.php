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
				<div class="formCreateRoom">
				{!! Form::open(['url' => './game']) !!}
					{!! Form::hidden('typeRequest', 'create') !!}
					{!! Form::hidden('idUser', Auth::id()) !!}
					
					{!! Form::label('name', 'Nom: ') !!}
					{!! Form::text('name') !!}
					<br/>
					{!! Form::label('nbPlayer', 'Nombre de joueurs maximum: ') !!}
					{!! Form::number('nbPlayer') !!}
					<br/>
					{!! Form::label('duration', 'Durée d'un round: ') !!}
					{!! Form::number('duration') !!}
					<br/>
					{!! Form::submit('Créer') !!}
				{!! Form::close() !!}
				</div>
            </div>
        </div>
    </div>
</div>
@endsection