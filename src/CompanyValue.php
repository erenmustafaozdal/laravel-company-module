<?php

namespace ErenMustafaOzdal\LaravelCompanyModule;

use Illuminate\Database\Eloquent\Model;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class CompanyValue extends Model
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'title','value' ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['company'];
    public $timestamps = false;





    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the photo of the company.
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the value attribute.
     * clean iframe for xss atack
     *
     * @param string $value
     * @return string
     */
    public function getValueAttribute($value)
    {
        return clean($value, 'iframe');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    /**
     * model boot method
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * model saved method
         *
         * @param $model
         */
        parent::saved(function($model)
        {
            // cache forget
            \Cache::forget('company_values');
        });

        /**
         * model deleted method
         *
         * @param $model
         */
        parent::deleted(function($model)
        {
            // cache forget
            \Cache::forget('company_values');
        });
    }
}
