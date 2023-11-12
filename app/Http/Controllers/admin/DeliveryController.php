<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\delivery;

use App\Models\products;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
class DeliveryController extends Controller
{
    public function index(Request $request){
        $Delivery =delivery::latest();
        if(!empty($request->get('keyworld'))){
           $Delivery =$Delivery->where('delivery_code','like','%'.$request->get('keyworld').'%');
        }
       $Delivery =$Delivery->paginate(8);
        return view('admin.delivery.list',compact('Delivery'));
    }
    public function create(){
        $Products = products::orderBy('product_name','ASC')->get();
        $data['Product'] = $Products;
        return view('admin.delivery.create',$data);
    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'product'=>'required',
            'delivery_code'=>'required|unique:Delivery',
            'quantity'=>'required',
            
        ]);
            if($validatior->passes()){
                $Delivery = new delivery();
                $Delivery->delivery_code = $request->delivery_code;
                $Delivery->products_id = $request->product;        
                $Delivery->quantity = $request->quantity;
                $Delivery->save();
                
                // save image here
                $request->session()-> flash('success','Delivery added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Delivery added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function edit($DeliveryID,Request $request){
        $Delivery = Delivery::find($DeliveryID);
        
        if(empty($Delivery)){
            $request->session()->flash('error','delivery not found');
            return redirect()->route('delivery.index');
        }
        $Products = products::orderBy('product_name','ASC')->get();
        $data['Product'] = $Products;
      
        return view('admin.delivery.edit',compact('Delivery'),$data);
    }
    public function update($DeliveryID,Request $request){
        $Delivery = delivery::find($DeliveryID);
        if(empty($Delivery)){
            $request->session()->flash('error','delivery not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'delivery not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'product'=>'required',
            'delivery_code'=>'required|unique:Delivery,delivery_code,'.$Delivery->id.',id',
            'quantity'=>'required',
            
        ]);
            if($validatior->passes()){
                $Delivery->delivery_code = $request->delivery_code;
                $Delivery->products_id = $request->product;        
                $Delivery->quantity = $request->quantity;
                $Delivery->save();
                
                $request->session()-> flash('success','delivery updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'delivery updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($DeliveryID,Request $request){
        $Delivery = delivery::find($DeliveryID);

        if(empty($Delivery)){
            $request->session()-> flash('error','delivery not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'delivery not found'
                ]);
            // return redirect()->route('delivery.index');
        }
        $Delivery->delete();
        $request->session()-> flash('success','delivery deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'delivery deleted successfully'
        ]);
    }
}


