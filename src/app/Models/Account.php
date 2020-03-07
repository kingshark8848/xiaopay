<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasNonIncrementUId;

    const GENDER__MALE = "male";

    const GENDER__FEMALE = "female";
    const GENDER__OTHER = "other";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public $incrementing = false;

    public static function allGenders()
    {
        return [
            self::GENDER__MALE,
            self::GENDER__FEMALE,
            self::GENDER__OTHER,
        ];
    }

    public static function idPrefix(): string
    {
        return "ac_";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
