<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FormAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\AccountUser as Account;
class AccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $accounts = Account::where('user_id', $request->user)->get();

            return response()->json([
                'status'  => 200,
                'accounts'   =>  $accounts
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

     /**
     * Display a single of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $account = Account::findOrFail($request->account);
            //$account = Account::where('id', $request->account)->first();

            return response()->json([
                'status'  => 200,
                'account'   =>  $account
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormAccountRequest $request)
    {
        try {
            $account            = new Account();
            $account->name      = $request->name;
            $account->email     = $request->email;
            $account->dni       = $request->dni;
            $account->phone     = $request->phone;
            $account->bank      = $request->bank;
            $account->number    = $request->number;
            $account->type      = $request->type;
            $account->user_id   = $request->user_id;
            $saved = $account->save();
            if($saved)
                return response()->json(['success' => true, 'message' => 'Cuenta agregada exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormAccountRequest $request, Account $Account)
    {
        try {
            $account            = Account::findOrFail($Account->id);
            $exists             = $account->CashRequest->whereIn('status', ['pending','created'])->count();
            if($exists>0) {
                return response()->json(['success' => false, 'message' => 'La Cuenta no se puede actualizar, tiene una solicitud abierta de retiro'], 200);
            }

            $account->name      = $request->name;
            $account->email     = $request->email;
            $account->dni       = $request->dni;
            $account->phone     = $request->phone;
            $account->bank      = $request->bank;
            $account->number    = $request->number;
            $account->type      = $request->type;
            $account->user_id   = $request->user_id;
            $update = $account->save();

            if($update)
                return response()->json(['success' => true, 'message' => 'La Cuenta ha sido actualizada exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $account = Account::findOrFail($id);
            $exists   = $account->CashRequest->count();
            if($exists>0) {
                return response()->json(['success' => false, 'message' => 'La Cuenta no se puede eliminar, tiene una solicitud abierta de retiro'], 200);
            }

            $delete = $account->delete();
            if ($delete)
                return response()->json(['success' => true, 'message' => 'Cuenta eliminada exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
