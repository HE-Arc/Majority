<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RoomController extends Controller
{
    public function show()
    {
       $characters = array(
						array("Test", "la première salle", 2,10),
						array("Fun", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut a felis ipsum. Quisque nec malesuada elit. Nulla varius est diam, vel porta est elementum eu. Sed ante elit, molestie et lacus a, aliquam facilisis ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris in turpis sed sem tempor venenatis congue non eros. Maecenas pretium mi orci, nec mattis sapien sollicitudin ut. Fusce imperdiet ante ut venenatis viverra. Etiam nec metus ac orci iaculis tincidunt. Cras mattis scelerisque luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed fermentum, odio eu aliquam dapibus, velit dolor ultrices libero, tincidunt feugiat ex dui at felis. Vestibulum vel quam tempus, volutpat sem et, feugiat mi. Morbi suscipit nibh nisl. Fusce in tellus ante. Integer vel consequat orci.", 4,8),
						array("Bonjour", "Venez jouer", 2,6)
						);
					
       return view('rooms')->withCharacters($characters);
    }
}
