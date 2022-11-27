<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->get();

        return view('user.dashboard', [
            'vehicles' => $vehicles
        ]);
    }

    public function bid(Request $request)
    {
        $request->validate([
            'vehicle_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
        ]);

        try{
            $vehicle = Vehicle::find($request->vehicle_id);
            if(is_null($vehicle))
            {
                return redirect()->back()->with('error', 'Vehicle not found');
            }

            $already = Bid::where('user_id', Auth::id())->where('vehicle_id', $request->vehicle_id)->first();
            if(!is_null($already))
            {
                return redirect()->back()->with('error', 'You cannot place a bid on this vehicle more than once.');
            }else{

                if($vehicle->price >= $request->amount)
                {
                    return redirect()->back()->with('error', 'Raise your bidding amount.');
                }

                $five = Bid::where('vehicle_id', $request->vehicle_id)->count();
                if($five >= 5)
                {
                    return redirect()->back()->with('error', 'Bidding maximum reached');
                }

                $bid = new Bid();
                $bid->user_id = Auth::id();
                $bid->vehicle_id = $request->vehicle_id;
                $bid->amount = $request->amount;
                $bid->save();

                return redirect()->back()->with('success', 'Successfully placed a bid');
            }
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }
}
