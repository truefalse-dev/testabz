<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function Tinify\fromFile;

class UserService
{
    private $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    public function store($request): User
    {
        $file = $request->file('photo');

        $filename = sprintf('%s.jpg', $file->getFilename());

        $resized = fromFile($file->getRealPath())
            ->resize([
                'method' => 'cover',
                'width' => 70,
                'height' => 70,
            ]);

        $this->storage->put($filename, $resized->toBuffer());

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->position_id = $request->input('position_id');
        $user->password = Hash::make(Str::random(10));
        $user->photo = $filename;
        $user->save();

        return $user;
    }
}
