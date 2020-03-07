<?php


namespace App\Models;


use Illuminate\Support\Str;

/**
 * Trait HasNonIncrementUId
 * @package App\Models
 */
trait HasNonIncrementUId
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = self::idPrefix().self::genUniqueId();
        });
    }

    /**
     * @return string 3 character. e.g : ur_
     */
    abstract public static function idPrefix(): string ;

    public static function genUniqueId()
    {
        $uuid = Str::uuid();
        return gmp_strval(gmp_init(str_replace('-', '', $uuid), 16), 62);
    }
}
