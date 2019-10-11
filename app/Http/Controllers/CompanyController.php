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

    public function createRank(Request $request)
    {
        $player = Player::where('user_id', Auth::id())->first();
        $company = $player->company;

        if($company->owner == $player->user_id) {
            $rank = new CompanyRanks();
            $rank->company_id = $company->id;
            $rank->name = $request->get('rank');
            $rank->position = $company->ranks()->count() + 1;
            $rank->save();
        }

        return redirect('/company/ranks');
    }

    public function ranksMoveUp($id)
    {
        $player = Player::where('user_id', Auth::id())->first();
        $company = $player->company;

        if($company->owner == $player->user_id) {
            $company_rank = CompanyRanks::find($id);
            $current_pos = $company_rank->position;

            if($current_pos === 1) return redirect('/company/ranks');

            $rank_above = CompanyRanks::where('company_id', $company->id)->where('position', $current_pos - 1)->first();

            $rank_above->position = $current_pos;
            $company_rank->position = $current_pos - 1;

            $rank_above->save();
            $company_rank->save();
        }

        return redirect('/company/ranks');
    }

    public function ranksMoveDown($id)
    {
        $player = Player::where('user_id', Auth::id())->first();
        $company = $player->company;

        if($company->owner == $player->user_id) {
            $company_rank = CompanyRanks::find($id);
            $current_pos = $company_rank->position;

            if($current_pos === $company->ranks()->count()) return redirect('/company/ranks');

            $rank_below = CompanyRanks::where('company_id', $company->id)->where('position', $current_pos + 1)->first();

            $rank_below->position = $current_pos;
            $company_rank->position = $current_pos + 1;

            $rank_below->save();
            $company_rank->save();
        }

        return redirect('/company/ranks');
    }

    public function ranks()
    {
        $player = Player::where('user_id', Auth::id())->first();

        if(!$player->company_id) {
            return redirect()->back();
        }

        $ranks = $player->company->ranks()->orderBy('position', 'ASC')->get();

        return view('company.ranks')->with(['ranks' => $ranks, 'active' => 'ranks']);
    }

    public function employees()
    {
        $player = Player::where('user_id', Auth::id())->first();

        if(!$player->company_id) {
            return redirect()->back();
        }

        $employees = $player->company->employees;

        return view('company.employees')->with(['employees' => $employees, 'active' => 'employees']);
    }
    
    public function management()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        if(!$player->company_id) {
            return redirect()->back();
        }
        
        return view('company.management')->with(['active' => 'management']);
    }

    public function invite(Request $request)
    {
        $player = Player::where('user_id', Auth::id())->first();
        $user = User::where('username', $request->get('player_name'))->first();
        $invitedPlayer = Player::where('user_id', $user->id)->first();
        $company = $player->company;

        if(!$player->company_id) {
            return redirect()->back();
        }
        
        if($invitedPlayer->company_id) {
            Session::flash('message', 'This user is in a company.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/company/management');
        }

        $invitedPlayer->company_id = $company->id;
        $invitedPlayer->company_rank_id = $company->ranks->last()->id;
        $invitedPlayer->save();
        
        return redirect('/company/management');
    }
}
