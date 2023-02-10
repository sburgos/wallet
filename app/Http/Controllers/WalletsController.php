<?php

namespace App\Http\Controllers;

use App\Models\Movements;
use App\Models\Wallets;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletsController extends Controller
{
    public function __invoke() : View
    {
        $wallets = Wallets::withSum([
            'movements as positive' => function (Builder $query) {
                $query->where('amount', '>', 0);
            }
        ], 'amount')->withSum([
            'movements as negative' => function (Builder $query) {
                $query->where('amount', '<', 0);
            }
        ], 'amount')->get();

        return view('wallets', [
            'wallets' => $wallets,
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $wallets = new Wallets();
        $wallets->name = $request->name;
        $wallets->type = $request->type;
        $wallets->save();

        $movements = new Movements();
        $movements->description = 'Inicio';
        $movements->amount = ($request->type == 'budget' ? $request->amount : $request->amount * -1) * 100;
        $movements->type = 'initial';
        $movements->wallets_id = $wallets->id;
        $movements->done_date = Carbon::now();
        $movements->save();

        return back();
    }
}
