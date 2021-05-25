<?php

namespace App\Http\Controllers;

use App\Cart_model;
use App\Orders_model;
use App\Ligne;
use App\Products_model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    public function index(){
        
        $session_id=Session::get('session_id');
        $cart_datas=Cart_model::where('session_id',$session_id)->get();
        $total_price=0;
      
        foreach ($cart_datas as $cart_data){
            $total_price+=$cart_data->price*$cart_data->quantity;
        
        }
        #print()
       
        #dd($or->lignes);

        $shipping_address=DB::table('delivery_address')->where('users_id',Auth::id())->first();
        return view('checkout.review_order',compact('shipping_address','cart_datas','total_price'));
    }
    public function order(Request $request){
        $input_data=$request->all();
        $payment_method=$input_data['payment_method'];
       $or= Orders_model::create($input_data);
        $session_id=Session::get('session_id');
        $cart_datas=Cart_model::where('session_id',$session_id)->get();
        foreach ($cart_datas as $cart_data){
            $ligne = new Ligne;
            $ligne->quantity = $cart_data->quantity;
            $ligne->product_id = $cart_data->products_id;
            $ligne->order_id=$or->id;
            $ligne->save();

        }
        Cart_model::where('session_id',$session_id)->delete();


        if($payment_method=="COD"){
            return redirect('/cod');
        }else{
            return redirect('/paypal');
        }
    }
    public function cod(){
        $user_order=Orders_model::where('users_id',Auth::id())->first();
        return view('payment.cod',compact('user_order'));
    }
    public function paypal(Request $request){
        $who_buying=Orders_model::where('users_id',Auth::id())->first();
        return view('payment.paypal',compact('who_buying'));
    }
}
