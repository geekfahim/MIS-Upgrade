<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, CommonTrait;

    public static function getUniqueFileName(): string
    {
        $filename = md5(Str::random(15) . uniqid());
        $exists = static::where("name", "LIKE", "%{$filename}%")->exists();
        if ($exists) {
            self::getUniqueFileName();
        }
        return $filename;
    }

    public static function resourceDelete(string $path, string $name, string $disk = 'public'): bool
    {
        $file = ($path && $name) ? "{$path}/{$name}" : null;
        if ($file && Storage::disk($disk)->exists($file)) {
            Storage::disk($disk)->delete($file);
            return true;
        }
        return false;
    }

    public function getPathAttribute($value)
    {
        return asset("storage/{$value}/{$this->name}");
    }

    public function resource(): MorphTo
    {
        return $this->morphTo();
    }
}
