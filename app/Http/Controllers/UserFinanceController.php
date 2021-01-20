<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $user = User::find($id);
        if ($user == NULL) {
            return response()->json(array(
                "message" => "User not found!",
            ), 404);
        }

        return $user->finances()
            ->select('id', 'type', 'category', 'memo', 'amount', 'date')
            ->get();
    }

}
