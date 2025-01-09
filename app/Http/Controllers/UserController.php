<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\UserResource;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Resources\User\UserResourceCollection;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        readonly private UserService $service
    ) {
    }

    public function index(IndexRequest $request): UserResourceCollection
    {
        return UserResourceCollection::make(User::query()->latest()->paginate($request->input('count')))->additional([
            'success' => true
        ]);
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user)->additional([
            'success' => true
        ]);
    }

    public function store(StoreRequest $request): UserResource
    {
        return UserResource::make($this->service->store($request))->additional([
            'success' => true
        ]);
    }
}
