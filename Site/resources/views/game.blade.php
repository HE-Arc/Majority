@extends('layouts.app')

@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/majority.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Partie</div>
				<div class="questionsReponses">
				<p class="question">Qui a découvert l'Amérique?</p>
				<table class="listReponses">
					<tr>
						<td><button type="button" id="reponse1" class="reponse">42</button></td>
						<td><button type="button" id="reponse2" class="reponse">Obiwan Kenobi</button></td>
					</tr>
					<tr>
						<td><button type="button" id="reponse3" class="reponse">Bleu</button></td>
						<td><button type="button" id="reponse4" class="reponse">Une girafe</button></td>
					</tr>
				</table>
				</div>
				<div class="joueurs">
				
				</div>
            </div>
        </div>
    </div>
</div>
@endsection