<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAspirantRequest;
use App\Models\Aspirant;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
class AspirantController extends Controller
{
	public function index()
	{
		try {
			$user = JWTAuth::parseToken()->authenticate();
			$cacheKey = 'aspirants_' . $user->id;

			$aspirants = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user) {
				if ($user->role === "agent") {
					return Aspirant::where('owner', $user->id)->get();
				} else {
					Gate::authorize('viewAny', [User::class, $user->role]);
					return Aspirant::all();
				}
			});

			return response()->json([
				"meta" => [
					'success' => true,
					'errors' => []
				],
				"data" => $aspirants
			]);
		} catch (\Exception $e) {
			return response()->json([
				"meta" => [
					'success' => false,
					'errors' => 'Profile not authorized to perform this action'
				],
			], 401);
		}
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
		try {
			$user = JWTAuth::parseToken()->authenticate();
			Gate::authorize('create', [User::class, $user->role]);

			$aspirant = Aspirant::create([
				"name" => $request->name,
				"source" => $request->source,
				"owner" => $request->owner,
				"created_at" => date('Y-m-d h:i:s'),
				"created_by" => $user->id,
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
		} catch (\Exception $e) {
			return response()->json([
				"meta" => [
					'success' => false,
					'errors' => 'Profile not authorized to perform this action'
				],
			], 401);
		}
	}
}
