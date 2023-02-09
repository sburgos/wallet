<?php

namespace App\Http\Controllers;

use App\Models\Movements;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovementsController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->sum == 'decrease') {
            $request->amount *= -1;
        }

        $movements = new Movements();
        $movements->description = $request->description;
        $movements->amount = $request->amount * 100;
        $movements->type = $request->type;
        $movements->save();

        return back();
    }

    public function all()
    {
        $movements = Movements::orderByDesc('id')->get();

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

        return view('home', [
            'movements' => $movements,
            'today' => round(($daily*$daysUntilToday - $spent + $daily) / 100, 2),
        ]);
    }
}
