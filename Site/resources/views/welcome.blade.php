@extends('layouts.app')

@section('content')
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