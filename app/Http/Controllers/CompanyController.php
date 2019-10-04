<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyRanks;
use App\CompanyType;
use App\Http\Requests\CompanyRequest;
use App\Player;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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


        return view('company.index')->with(['company' => $company, 'active' => 'home']);
    }

    public function create(CompanyRequest $request)
    {
        $player = Player::where('user_id', Auth::id())->first();

        if($player->money < 1e6) {
            Session::flash('message', 'You don\'t have enough money to start a company.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/company');
        }

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

        return redirect('/company');
    }

    public function createRank(Request $request)
    {
        $player = Player::where('user_id', Auth::id())->first();
        $company = $player->company;

        if($company->owner == $player->user_id) {
            $rank = new CompanyRanks();
            $rank->company_id = $company->id;
            $rank->name = $request->get('rank');
            $rank->save();
        }

        return redirect('/company/ranks');
    }

    public function ranks()
    {
        $player = Player::where('user_id', Auth::id())->first();

        if(!$player->company_id) {
            return redirect()->back();
        }

        $ranks = $player->company->ranks;

        return view('company.ranks')->with(['ranks' => $ranks, 'active' => 'ranks']);
    }
}
