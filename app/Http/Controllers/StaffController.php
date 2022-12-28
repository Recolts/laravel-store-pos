<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => Staff::with([])->get(),
            'status' => 'success',
            'message' => 'Get staff success',
        ]);    
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = Staff::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'age' => $request->age,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create staff failed',
            ]);
        }
        
        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create staff success',
        ]);    
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = Staff::find($id);    

            if($data == null){
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Staff not found',
                ]);
            }

            $data->firstName = $request->get('firstName');
            $data->lastName = $request->get('lastName');
            $data->age = $request->get('age');

            $data->save();
            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => $e,
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Update staff success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Staff::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get staff success',
        ]);    
    }

    public function destroy($id)
    {
        $data = Staff::find($id);

        if($data == null){
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Staff not found',
            ]);
        }
        $data->delete();
        
        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete staff success',
        ]);
    }
}
