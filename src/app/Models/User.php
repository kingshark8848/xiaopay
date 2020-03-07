<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed month_salary
 * @property mixed month_expense
 */
class User extends Model
{
    use HasNonIncrementUId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public $incrementing = false;

    public static function idPrefix(): string
    {
        return "us_";
    }

}
