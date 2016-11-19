<?php

namespace ErenMustafaOzdal\LaravelCompanyModule\Http\Requests\Company;

use App\Http\Requests\Request;
use Sentinel;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return hasPermission('admin.company.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max_photo = config('laravel-company-module.company.uploads.photo.max_size');
        $mimes_photo = config('laravel-company-module.company.uploads.photo.mimes');

        $rules = [
            'title'             => 'required|max:255',
            'slug'              => 'alpha_dash|max:255',
            'meta_title'        => 'max:255',
            'meta_description'  => 'max:255',
            'meta_keywords'     => 'max:255',
            'group-value'       => 'array',
            'value_title'       => '',
            'value'             => '',
        ];

        // photo elfinder mi
        if ($this->has('photo') && is_string($this->photo)) {
            $rules['photo'] = "elfinder_max:{$max_photo}|elfinder:{$mimes_photo}";
        } else  if (is_array($this->photo)){
            $rules['photo'] = 'array|max:' . config('laravel-company-module.company.uploads.photo.max_file');
            for($i = 0; $i < count($this->file('photo')); $i++) {
                $rules['photo.' . $i] = "max:{$max_photo}|image|mimes:{$mimes_photo}";
            }
        } else {
            $rules['photo'] = "max:{$max_photo}|image|mimes:{$mimes_photo}";
        }

        return $rules;
    }
}
