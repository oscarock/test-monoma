<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAspirantRequest;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Repositories\AspirantRepositoryInterface;

class AspirantController extends Controller
{
	private $aspirantRepository;

	public function __construct(AspirantRepositoryInterface $aspirantRepository)
    {
        $this->aspirantRepository = $aspirantRepository;
    }

	public function index()
	{
		try {
			$user = JWTAuth::parseToken()->authenticate();
			$cacheKey = 'aspirants_' . $user->id;

			$aspirants = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user) {
				if ($user->role === "agent") {
					return $this->aspirantRepository->getByOwner($user->id);
				} else {
					Gate::authorize('viewAny', [User::class, $user->role]);
					return $this->aspirantRepository->getAll();
				}
			});

			return $this->jsonResponse(true, $aspirants);
		} catch (\Exception $e) {
			return $this->jsonResponse(false, null, ['Profile not authorized to perform this action'], 401);
		}
	}

	public function show($id)
	{
		$aspirant = $this->aspirantRepository->getById($id);
		if (!$aspirant) {
			return $this->jsonResponse(false, null, ['No lead found'], 404);
		}else{
			return $this->jsonResponse(true, $aspirant);
		}
	}

	public function store(AddAspirantRequest $request){
		try {
			$user = JWTAuth::parseToken()->authenticate();
			Gate::authorize('create', [User::class, $user->role]);

			$aspirant = $this->aspirantRepository->create([
				"name" => $request->name,
				"source" => $request->source,
				"owner" => $request->owner,
				"created_at" => date('Y-m-d h:i:s'),
				"created_by" => $user->id,
			]);
			if($aspirant->save()){
				return $this->jsonResponse(true, $aspirant);
			}
		} catch (\Exception $e) {
			return $this->jsonResponse(false, null, ['Profile not authorized to perform this action'], 401);
		}
	}

	private function jsonResponse($success, $data = null, $errors = [], $statusCode = 200)
	{
		return response()->json([
			"meta" => [
				'success' => $success,
				'errors' => $errors
			],
			"data" => $data
		], $statusCode);
	}
}
