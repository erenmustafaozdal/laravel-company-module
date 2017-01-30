<?php

namespace ErenMustafaOzdal\LaravelCompanyModule;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class Company extends Model
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'company_profile',
        'mission',
        'vision',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];





    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */





    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the company photos.
     */
    public function photos()
    {
        return $this->hasMany('App\CompanyPhoto','company_id');
    }

    /**
     * Get the company values.
     */
    public function values()
    {
        return $this->hasMany('App\CompanyValue','company_id');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the company profile attribute.
     * clean iframe for xss atack
     *
     * @param string $company_profile
     * @return string
     */
    public function getCompanyProfileAttribute($company_profile)
    {
        return clean($company_profile, 'iframe');
    }

    /**
     * Get the mission attribute.
     * clean iframe for xss atack
     *
     * @param string $mission
     * @return string
     */
    public function getMissionAttribute($mission)
    {
        return clean($mission, 'iframe');
    }

    /**
     * Get the vision attribute.
     * clean iframe for xss atack
     *
     * @param string $vision
     * @return string
     */
    public function getVisionAttribute($vision)
    {
        return clean($vision, 'iframe');
    }

    /**
     * Get the read attribute.
     *
     * @param integer $read
     * @return string
     */
    public function getReadAttribute($read)
    {
        return (int) $read;
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
            \Cache::forget('companies');
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
            \Cache::forget('companies');
            \Cache::forget('company_values');
        });
    }
}
