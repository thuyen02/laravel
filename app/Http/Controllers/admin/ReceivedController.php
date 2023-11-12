<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\received;

use App\Models\products;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
class ReceivedController extends Controller
{
    public function index(Request $request){
        $Received =received::latest();
        if(!empty($request->get('keyworld'))){
           $Received =$Received->where('received_code','like','%'.$request->get('keyworld').'%');
        }
       $Received =$Received->paginate(8);
        return view('admin.received.list',compact('Received'));
    }
    public function create(){
        $Products = products::orderBy('product_name','ASC')->get();
        $data['Product'] = $Products;
        return view('admin.received.create',$data);
    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'product'=>'required',
            'received_code'=>'required|unique:Received',
            'quantity'=>'required',
            
        ]);
            if($validatior->passes()){
                $Received = new received();
                $Received->received_code = $request->received_code;
                $Received->products_id = $request->product;        
                $Received->quantity = $request->quantity;
                $Received->save();
                
                // save image here
                $request->session()-> flash('success','Received added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Received added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function edit($ReceivedID,Request $request){
        $Received = Received::find($ReceivedID);
        
        if(empty($Received)){
            $request->session()->flash('error','received not found');
            return redirect()->route('received.index');
        }
        $Products = products::orderBy('product_name','ASC')->get();
        $data['Product'] = $Products;
      
        return view('admin.received.edit',compact('Received'),$data);
    }
    public function update($ReceivedID,Request $request){
        $Received = received::find($ReceivedID);
        if(empty($Received)){
            $request->session()->flash('error','received not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'received not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'product'=>'required',
            'received_code'=>'required|unique:Received,received_code,'.$Received->id.',id',
            'quantity'=>'required',
            
        ]);
            if($validatior->passes()){
                $Received->received_code = $request->received_code;
                $Received->products_id = $request->product;        
                $Received->quantity = $request->quantity;
                $Received->save();
                
                $request->session()-> flash('success','received updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'received updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($ReceivedID,Request $request){
        $Received = received::find($ReceivedID);

        if(empty($Received)){
            $request->session()-> flash('error','received not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'received not found'
                ]);
            // return redirect()->route('received.index');
        }
        $Received->delete();
        $request->session()-> flash('success','received deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'received deleted successfully'
        ]);
    }
}


