<?php

namespace App\Http\Controllers;

use App\Models\Movements;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovementsController extends Controller
{
    public function store(Request $request) : RedirectResponse
    {
        if($request->sum == 'decrease') {
            $request->amount *= -1;
        }

        $movements = new Movements();
        $movements->description = $request->description;
        $movements->amount = $request->amount * 100;
        $movements->type = $request->type;
        $movements->wallets_id = $request->walletId;
        $movements->done_date = Carbon::parse($request->done_date, 'America/Lima')->utc()->toDateTimeString();
        $movements->save();

        return back();
    }

    public function __invoke(Request $request) : View
    {
        $movements = Movements::where('wallets_id', $request->walletId)->orderByDesc('done_date')->get();

        $total = 0;
        $spent = 0;
        foreach($movements as $move) {
            if($move->amount < 0) {
                $spent += $move->amount * -1;
            } else {
                $total += $move->amount;
            }
        }
        $daysInMonth = Carbon::today('America/Lima')->daysInMonth;
        $daily = $total / $daysInMonth;
        $daysUntilEndMonth = Carbon::today('America/Lima')->diffInDays(Carbon::now('America/Lima')->endOfMonth());
        $daysUntilToday = $daysInMonth - $daysUntilEndMonth - 1;

        return view('movements', [
            'id' => $request->walletId,
            'movements' => $movements,
            'today' => round(($daily*$daysUntilToday - $spent + $daily) / 100, 2),
        ]);
    }
}
