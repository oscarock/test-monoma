<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirant;

class AspirantController extends Controller
{
    public function index()
    {
			$aspirants = Aspirant::all();
			return response()->json([
				"meta" => [
					'success' => true,
					'errors' => []
				],
				"data" => $aspirants
			]);
    }

    public function show($id)
		{
			$aspirant = Aspirant::find($id);
			if (!$aspirant) {
				return response()->json([
					"meta" => [
						'success' => false,
						'errors' => 'No lead found'
					],
				], 404);
			}else{
				return response()->json([
					"meta" => [
						'success' => true,
						'errors' => []
					],
					"data" => $aspirant
				]);
			}
  	}
}
