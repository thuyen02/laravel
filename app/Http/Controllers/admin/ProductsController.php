<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\products;
use App\Models\productsImage;
use App\Models\TempImage;
use App\Models\unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
class ProductsController extends Controller
{
    public function index(Request $request){
        $Products = products::latest('id')->with('product_images');
        if(!empty($request->get('keyworld'))){
            $Products = $Products->where('product_name','like','%'.$request->get('keyworld').'%');
         }
         $Products =$Products->paginate(8);
        return view('admin.products.list', compact('Products'));
    }
  public function create(){
    $data=[];
    $Unit = unit::orderBy('name','ASC')->get();
    $data['Unit'] = $Unit;
    $Category = category::orderBy('category_name','ASC')->get();
    $data['Category'] = $Category;
    return view('admin.products.create',$data);
  }
  public function store(Request $request){

    $validatior= Validator::make($request->all(),[
        'product_name'=>'required',
        'price'=>'required',
        'unit'=>'required',
        'category'=>'required',
        'product_code'=>'required|unique:Products',
    ]);
        if($validatior->passes()){
            $Products = new products();
            $Products->product_quantity = $request->product_quantity;
            $Products->product_code = $request->product_code;
            $Products->product_name = $request->product_name;        
            $Products->category_id = $request->category;
            $Products->status = $request->status;
            $Products->unit_id = $request->unit;
            $Products->price = $request->price;        
            $Products->price_retail = $request->price_retail;
            $Products->price_wholesale = $request->price_wholesale;
            $Products->save();

            if(!empty($request->image_array)){
                foreach($request->image_array as $temp_image_id){
                    $tempImageInfo =TempImage::find($temp_image_id);
                    $extArray = explode('.',$tempImageInfo->name);
                    $ext = last($extArray);
                    $productsImage = new productsImage();
                    $productsImage->products_id = $Products->id;
                    $productsImage->image = 'NULL';
                    $productsImage->save();

                    $imageName = $Products->id.'-'.$productsImage->id.'-'.time().'.'.$ext;
                    $productsImage->image = $imageName;
                    $productsImage->save();

                    //large Image
                    $sourcePath= public_path().'/temp/'.$tempImageInfo->name;
                    $destPath = public_path().'/uploads/product/large/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function ($constraint){
                            $constraint->aspectRatio();
                    });

                    $image->save($destPath);
                    //Small Image
                    $sourcePath= public_path().'/temp/'.$tempImageInfo->name;
                    $destPath = public_path().'/uploads/product/small/'.$imageName  ;
                    $image = Image::make($sourcePath);
                    $image->fit(300,300);
                    $image->save($destPath);
                }
            }

            $request->session()-> flash('success','products added successfully');
            return response()->json([
                'status'=>true,
                'message'=>'products added successfully'
            ]);
        }else{
            return response()->json([
                'status' =>true,
                'errors' =>$validatior->errors()
            ]);

        }
  
}
}
