<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->get();
        return view('admin.dashboard', [
            'vehicles' => $vehicles
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'make' => ['required', 'string'],
            'model' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,gif', 'max:2048']
        ]);

        try{
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $vehicle = new Vehicle();
            $vehicle->make = $request->make;
            $vehicle->model = $request->model;
            $vehicle->condition = $request->condition;
            $vehicle->price = $request->price;
            $vehicle->file = $imageName;
            $vehicle->save();

            return redirect()->back()->with('success', 'Successfully added new vehicle.');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'vehicle_id' => ['required', 'integer'],
            'make' => ['required', 'string'],
            'model' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,gif', 'max:2048']
        ]);

        try{
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle->make = $request->make;
            $vehicle->model = $request->model;
            $vehicle->condition = $request->condition;
            $vehicle->price = $request->price;
            $vehicle->file = $imageName;
            $vehicle->save();

            return redirect()->back()->with('success', 'Successfully added new vehicle.');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }
}
