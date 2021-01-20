<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Finance;

class FinanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt-check', ["except" => ["index", "show"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return DB::table('finances')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'category' => 'required',
            'memo' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $err = array(
                'type' => $errors->first('type'),
                'category' => $errors->first('category'),
                'memo' => $errors->first('memo'),
                'amount' => $errors->first('amount'),
                'date' => $errors->first('date'),
            );

            return response()->json(array(
                'message' => 'Cannot process request',
                'errors' => $err
            ), 422);
        }

        $finance = new Finance;
        $finance->type = $request->input("type");
        $finance->category = $request->input("category");
        $finance->memo = $request->input("memo");
        $finance->amount = $request->input("amount");
        $finance->date = $request->input("date");
        $finance->save();

        return response()->json(array(
            "message" => "Finance created Successful",
            "finance" => $finance
        ), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finance = Finance::find($id);
        if ($finance == NULL) {
            return response()->json(array(
                "message" => "Finance not found!",
            ), 404);
        }

        return response()->json(array($finance), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $finance = Finance::find($id);
        if ($finance == NULL) {
            return response()->json(array(
                "message" => "Finance not found!",
            ), 404);
        }

        if ($request->has('type')){
            $finance->type = $request->input('type');
        }
        
        if ($request->has('category')){
            $finance->category = $request->input('category');
        }

        if ($request->has('memo')){
            $finance->memo = $request->input('memo');
        }
        
        if ($request->has('amount')){
            $finance->amount = $request->input('amount');
        }
        
        if ($request->has('date')){
            $finance->date = $request->input('date');
        }
        $finance->save();

        return response()->json(array(
            "message" => "Finance is updated!",
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $finance = Finance::find($id);
        if ($finance == NULL) {
            return response()->json(array(
                "message" => "Finance not found!",
            ), 404);
        }
        
        $finance->delete();

        return response()->json(array(
            "message" => "Finance is deleted!",
        ));
    }
}
