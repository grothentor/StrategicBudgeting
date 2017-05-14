<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CompaniesController extends Controller
{
    public function index() {
        return Company::query()->select(['id', 'name'])->get()->map(function($item, $key) {
            return [$item->id, $item->name];
        });
    }

    public function store(Request $request) {
        $company = $request->all();
        $validator = Validator::make($company, Company::$validateRules);
        if ($validator->errors()->all()) return ['errors' => $validator->errors()->all()];

        $company['password'] = bcrypt($company['password']);
        $company = Company::query()->create($company);
        return ['companyId' => $company->id];
    }
}