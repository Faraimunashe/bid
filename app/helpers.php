<?php

use App\Models\Bid;

function get_highest_bid($vehicle_id)
{
    $highests = Bid::where('vehicle_id', $vehicle_id)->max('amount');

    //dd($highests);
    if(is_null($highests))
    {
        return 0;
    }

    return $highests->amount;
}
