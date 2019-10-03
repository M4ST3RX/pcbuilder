<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyType;
use App\Http\Requests\CompanyRequest;
use App\Player;
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
        $player = Player::where('user_id', Auth::id())->first();

        if(!$player->company_id) {
            $company_types = CompanyType::all();
            return view('company.create')->with(['company_types' => $company_types]);
        }

        $company = Company::find($player->company_id);

        return view('company.index')->with(['company' => $company]);
    }

    public function create(CompanyRequest $request)
    {
        $player = Player::where('user_id', Auth::id())->first();

        if(!$player->company_id) {
            $company = new Company();
            $company->owner = Auth::id();
            $company->type = $request->get('company_type');
            $company->name = $request->get('company_name');
            $company->slogan = $request->get('company_slogan');

            $company->save();

            $player->company_id = $company->id;
            $player->save();
        }
    }
}
