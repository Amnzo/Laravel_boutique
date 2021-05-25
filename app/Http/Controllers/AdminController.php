<?php

namespace App\Http\Controllers;

use App\User;
use App\Orders_model;
use App\Ligne;
use App\Products_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $orders_count = Orders_model::count(); 
        $users_count=User::count(); 
        //dd($count);
        $menu_active=1;
        return view('backEnd.index',compact('menu_active','orders_count','users_count'));
    }

    
    public function allorders(){
        $orders=Orders_model::orderBy('created_at','ASC')->get();
        $menu_active=1;
        return view('backEnd.orders.index',compact('orders','menu_active'));
        
    }

    public function soft($id)
    {   

        $response ="";
       
        $user = User::find($id);
        if ($user) {
            Orders_model::where('users_id', $user->id)->delete();
            $user = User::destroy($id);
            $response = "deleted";

        } else {

            $response ="notFoundMessage";
        }

        return response($response);
    }

    public function orderinfo($id){
        $menu_active=1;
        $lignes=Ligne::where('order_id', $id)->get();
        #dd($lignes);
        
    
        return view('backEnd.orders.order_d',compact('lignes','menu_active'));
        
        
        
        
    }
    public function settings(){
        $menu_active=0;
        return view('backEnd.setting',compact('menu_active'));
    }
    public function chkPassword(Request $request){
        $data=$request->all();
        $current_password=$data['pwd_current'];
        $email_login=Auth::user()->email;
        $check_pwd=User::where(['email'=>$email_login])->first();
        if(Hash::check($current_password,$check_pwd->password)){
            echo "true"; die();
        }else {
            echo "false"; die();
        }
    }
    public function updatAdminPwd(Request $request){
        $data=$request->all();
        $current_password=$data['pwd_current'];
        $email_login=Auth::user()->email;
        $check_password=User::where(['email'=>$email_login])->first();
        if(Hash::check($current_password,$check_password->password)){
            $password=bcrypt($data['pwd_new']);
            User::where('email',$email_login)->update(['password'=>$password]);
            return redirect('/admin/settings')->with('message','Password Update Successfully');
        }else{
            return redirect('/admin/settings')->with('message','InCorrect Current Password');
        }
    }





    /*public function login(Request $request){
        if($request->isMethod('post')){
            $data=$request->input();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
                echo 'success'; die();
            }else{
                return redirect('admin')->with('message','Account is Incorrect!');
            }
        }else{
            return view('backEnd.login');
        }
    }*/
}
