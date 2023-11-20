<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\AddAspirantRequest;
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

	public function store(AddAspirantRequest $request){
		$aspirant = Aspirant::create([
			"name" => $request->name,
			"source" => $request->source,
			"owner" => $request->owner,
			"created_at" => date('Y-m-d h:i:s'),
			"created_by" => 6,
		]);
		if($aspirant->save()){
			return response()->json([
				"meta" => [
					'success' => true,
					'errors' => []
				],
				"data" => $aspirant
			], 201);
		}
	}
}
