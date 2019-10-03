<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyType;
use App\Http\Requests\CompanyRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!Auth::user()->company_id) {
            $company_types = CompanyType::all();
            return view('company.create')->with(['company_types' => $company_types]);
        }

        $company = Company::find(Auth::user()->company_id);

        return view('company.index')->with(['company' => $company, 'active' => 'home']);
    }

    public function create(CompanyRequest $request)
    {
        if(!Auth::user()->company_id) {
            $company = new Company();
            $company->owner = Auth::id();
            $company->type = $request->get('company_type');
            $company->name = $request->get('company_name');
            $company->slogan = $request->get('company_slogan');

            $company->save();

            $user = User::find(Auth::id());
            $user->company_id = $company->id;
            $user->save();
        }

        return redirect('/company');
    }

    public function ranks()
    {
        if(!Auth::user()->company_id) {
            return redirect()->back();
        }

        $ranks = Auth::user()->company->ranks;

        return view('company.ranks')->with(['ranks' => $ranks, 'active' => 'ranks']);
    }
}
