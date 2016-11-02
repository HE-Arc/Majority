@extends('layouts.app')

@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/majority.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Choix des salles</div>

				<form action="./createRoom">
					<button type="submit" class="btnCreateRoom">Créer une salle</button>
				</form> 
				
				<table border="2" class="listSalles">
					<tr>
						<th>Salle</th>
						<th>Informations</th>
						<th>Place</th>
					</tr>
					<?php
					$listSalles = array(
						array("Test", "la première salle", 2,10),
						array("Fun", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut a felis ipsum. Quisque nec malesuada elit. Nulla varius est diam, vel porta est elementum eu. Sed ante elit, molestie et lacus a, aliquam facilisis ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris in turpis sed sem tempor venenatis congue non eros. Maecenas pretium mi orci, nec mattis sapien sollicitudin ut. Fusce imperdiet ante ut venenatis viverra. Etiam nec metus ac orci iaculis tincidunt. Cras mattis scelerisque luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed fermentum, odio eu aliquam dapibus, velit dolor ultrices libero, tincidunt feugiat ex dui at felis. Vestibulum vel quam tempus, volutpat sem et, feugiat mi. Morbi suscipit nibh nisl. Fusce in tellus ante. Integer vel consequat orci.", 4,8),
						array("Bonjour", "Venez jouer", 2,6)
						);
					
					foreach($listSalles as $salle){
						echo "<tr>";
						echo "<td>" . $salle[0] . "</td>";
						echo "<td>" . $salle[1] . "</td>";
						echo "<td>" . $salle[2] . "/" . $salle[3] . "</td>";
						echo "</tr>";
					}
					?>
				</table>
				
            </div>
        </div>
    </div>
</div>
@endsection