<?php

namespace App\Models;

use App\Core\HelperFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded =  ['id'];

    /**
     *  Boot Function
     */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->{'uid'} = HelperFunction::_uid();

        });
    }

    /**
     * @return Module Permissions
     */

    public function permission()
    {
        return $this->hasMany(\Spatie\Permission\Models\Permission::class,'module_id','id');
    }
}
