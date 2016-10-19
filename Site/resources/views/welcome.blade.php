@extends('layouts.app')

@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Accueil</div>

                @if(Auth::check())
					<p> Vous êtes connecté</p>
					<a href="rooms">Jouer</a>
                @endif

				
				@if(Auth::guest())
					<p> Vous n'êtes pas connecté</p>
				@endif
            </div>
        </div>
    </div>
</div>
@endsection