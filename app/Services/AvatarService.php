<?php

namespace App\Services;

use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class AvatarService
{
    public function processAvatar(User $user, $avatar)
    {
        $path = $this->getStoragePath($user->id);
        Storage::disk('public')->makeDirectory(Str::of($path)->dirname());
        Image::make($avatar)->fit(500)->save(Storage::disk('public')->path($path));
    }

    private static function getStoragePath($userId)
    {
        return Str::replace('[user_id]', $userId, config('settings.storage_avatar_path'));
    }

    public static function exists($userId)
    {
        return Storage::disk('public')->exists(self::getStoragePath($userId));
    }

    public static function getUrl($userId)
    {
        return Storage::url(self::getStoragePath($userId));
    }
}
