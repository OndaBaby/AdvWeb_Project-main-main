<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Storage;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $couriers = Courier::orderBy('id', 'DESC')->get();
        return response()->json($couriers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $courier = new Courier;
        $courier->courier_name = $request->courier_name;
        $courier->email = $request->email;
        $courier->contact_number = $request->contact_number;
        $courier->service_area = $request->service_area;
        $courier->img_path = ''; // Provide a default value

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $courier->img_path .= 'storage/images/' . $fileName . ','; // Append image path
            }
            $courier->img_path = rtrim($courier->img_path, ','); // Remove trailing comma
        }

        $courier->save();

        return response()->json(["success" => "Courier created successfully.", "courier" => $courier, "status" => 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courier = Courier::where('id', $id)->first();
        return response()->json($courier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return response()->json(["error" => "Courier not found.", "status" => 404]);
        }

        $courier->courier_name = $request->courier_name;
        $courier->email = $request->email;
        $courier->contact_number = $request->contact_number;
        $courier->service_area = $request->service_area;

        // Handle multiple image uploads
        if ($request->hasFile('uploads')) {
            $imagePaths = [];

            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $imagePaths[] = 'storage/images/' . $fileName;
            }

            $courier->img_path = implode(',', $imagePaths);
        }

        $courier->save();

        return response()->json(["success" => "Courier updated successfully.", "courier" => $courier, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Courier::find($id)) {
            Courier::destroy($id);
            $data = array('success' => 'deleted', 'code' => 200);
            return response()->json($data);
        }
        $data = array('error' => 'Courier not deleted', 'code' => 400);
        return response()->json($data);
    }
}
