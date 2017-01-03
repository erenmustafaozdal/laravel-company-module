<?php

namespace ErenMustafaOzdal\LaravelCompanyModule\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Company;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseController;
// events
use ErenMustafaOzdal\LaravelCompanyModule\Events\Company\StoreSuccess;
use ErenMustafaOzdal\LaravelCompanyModule\Events\Company\StoreFail;
use ErenMustafaOzdal\LaravelCompanyModule\Events\Company\UpdateSuccess;
use ErenMustafaOzdal\LaravelCompanyModule\Events\Company\UpdateFail;
// requests
use ErenMustafaOzdal\LaravelCompanyModule\Http\Requests\Company\UpdateRequest;

class CompanyController extends BaseController
{
    /**
     * default relation datas
     *
     * @var array
     */
    private $relations = [
        'values' => [
            'relation_type'     => 'hasMany',
            'relation'          => 'values',
            'relation_model'    => '\App\CompanyValue',
            'is_reset'          => true,
            'datas'             => null
        ]
    ];

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = Company::first();
        return view(config('laravel-company-module.views.company.edit'), compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $company = Company::first();
        $this->setEvents([
            'success'   => is_null($company) ? StoreSuccess::class : UpdateSuccess::class,
            'fail'      => is_null($company) ? StoreFail::class : UpdateFail::class
        ]);
        $this->setToFileOptions($request, ['photos.photo' => 'photo']);
        $relation = [];

        if ( ! is_null($company)) {
            $company->values()->delete();
        }
        if ($request->has('group-value')) {
            $this->relations['values']['datas'] = collect($request->get('group-value'))->reject(function($item)
            {
                return $item['value_title'] == '';
            })->map(function($item,$key)
            {
                $item['title'] = $item['value_title'];
                unsetReturn($item,'value_title');
                return $item;
            });
            $relation[] = $this->relations['values'];
        }
        $this->setOperationRelation($relation);
        is_null($company) ? $this->storeModel(Company::class,'edit') : $this->updateModel($company,'edit', false);
        return redirect( lmbRoute("admin.company.edit") );
    }

    /**
     * remove photo of the description
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function removePhoto(Request $request)
    {
        $company = Company::first();
        if ($company->photos()->where('id',$request->id)->first()->delete()) {
            return response()->json($this->returnData('success'));
        }
        return response()->json($this->returnData('error'));
    }
}
