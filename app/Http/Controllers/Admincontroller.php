<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class Admincontroller extends Controller
{

    //transaction
    public function show(){
        return Transaction::all();
    }

    public function create(Request $request){
        $user=Auth::user()->usertype;

        if($user=='1'){
           $request->validate([
            'amount'=>'',
            'payer'=>'required',
            'due_on'=>'required',
            'vat'=>'required',
            'is_vat_inclusive'=>'required',
            ]);

            $transaction = Transaction::create($request->all());

            return $transaction; 
        }
        else {
            return[
                "message"=>"Unauthorized Access",
            ];
        }
      
    }

    public function edit(Request $request,$id){
        $transaction=Transaction::find($id);
        $validte=$request->validate([
            'amount'=>'required',
            'payer'=>'required',
            'due_on'=>'required',
            'vat'=>'required',
            'is_vat_inclusive'=>'required',
        ]);
        $transaction->update($validte);
        return response()->json(['message'=>"updated successfully",$validte]);
    }

    public function delete($id){
        $transaction=Transaction::find($id);
        $transaction->delete();
        return[
            'message'=>'deleted done'
        ];
    }

    //record

    public function records_show($id){
        $record=Record::find($id);
        return $record;
    }

    public function records_create(Request $request){

        $request->validate([
             'amount' => 'required',
            'paid_on' => 'required',
         ]);
         return Record::create($request->all());
        
    }


    public function records_edit(Request $request,$id){
        $transaction=Record::find($id);
        $validte=$request->validate([
            'amount' => 'required',
            'paid_on' => 'required',
        ]);
        $transaction->update($validte);
        return response()->json(['message'=>"updated successfully",$validte]);
    }

    public function records_delete($id){
        $transaction=Record::find($id);
        $transaction->delete();
        return['message'=>'Deleted Successfully'];
    }
}
