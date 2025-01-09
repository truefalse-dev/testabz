<?php

namespace App\Http\Controllers;

use App\Models\UserPosition;
use App\Http\Resources\User\UserPositionResourceCollection;

class UserPositionController extends Controller
{
    public function index(): UserPositionResourceCollection
    {
        return UserPositionResourceCollection::make(UserPosition::all())
            ->additional([
                'success' => true,
            ]);
    }
}
