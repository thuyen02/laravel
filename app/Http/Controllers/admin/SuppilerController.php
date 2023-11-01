<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\suppiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuppilerController extends Controller
{
    //   public function index(Request $request){
     
    public function index(Request $request){
        $Suppiler =suppiler::latest();
        if(!empty($request->get('keyworld'))){
           $Suppiler =$Suppiler->where('suppiler_code','like','%'.$request->get('keyworld').'%');
        }
       $Suppiler =$Suppiler->paginate(10);
        return view('admin.Suppiler.list',compact('Suppiler'));
    }
    public function create(){
        return view('admin.Suppiler.create');

    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'suppiler_name'=>'required',
            'suppiler_code'=>'required|unique:Suppiler',
        ]);
            if($validatior->passes()){
                $Suppiler = new suppiler();
                $Suppiler->suppiler_code = $request->suppiler_code;
                $Suppiler->suppiler_name = $request->suppiler_name;        
                $Suppiler->phone_number = $request->phone_number;
                $Suppiler->email = $request->email;
                $Suppiler->status = $request->status;
                $Suppiler->save();

                $request->session()-> flash('success','Suppiler added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Unit added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function edit($SuppilerID,Request $request){
        $Suppiler = suppiler::find($SuppilerID);
        if(empty($Suppiler)){
            return redirect()->route('suppiler.index');
        }

        return view('admin.Suppiler.edit',compact('Suppiler'));
    }
    public function update($SuppilerID,Request $request){
        $Suppiler = suppiler::find($SuppilerID);
        if(empty($Suppiler)){
            $request->session()->flash('error','Suppiler not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'Suppiler not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'name'=>'required',
            'Suppiler_code'=>'required|unique:Suppiler,Suppiler_code,'.$Suppiler->id.',id',
        ]);
            if($validatior->passes()){
                $Suppiler->suppiler_code = $request->suppiler_code;
                $Suppiler->suppiler_name = $request->suppiler_name;        
                $Suppiler->phone_number = $request->phone_number;
                $Suppiler->email = $request->email;
                $Suppiler->status = $request->status;
                $Suppiler->save();

                $request->session()-> flash('success','Suppiler updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Suppiler updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($SuppilerID,Request $request){
        $Suppiler = suppiler::find($SuppilerID);

        if(empty($Suppiler)){
            $request->session()-> flash('error','Suppiler not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'Suppiler not found'
                ]);
            // return redirect()->route('Suppiler.index');
        }
        $Suppiler->delete();
        $request->session()-> flash('success','Suppiler deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'Suppiler deleted successfully'
        ]);
    }
}
