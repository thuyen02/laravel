<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\productsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
class ProductImageController extends Controller
{
    public function update(Request $request){

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();


        $productsImage = new productsImage();
        $productsImage->products_id = $request->products_id;
        $productsImage->image = 'NULL';
        $productsImage->save();

        $imageName =$request->products_id.'-'.$productsImage->id.'-'.time().'.'.$ext;
        $productsImage->image = $imageName;
        $productsImage->save(); 
        //large Image
        $destPath = public_path().'/uploads/product/large/'.$imageName;
        $image = Image::make($sourcePath);
        $image->resize(1400, null, function ($constraint){
                $constraint->aspectRatio();
        });

        $image->save($destPath);
        //Small Image
        $destPath = public_path().'/uploads/product/small/'.$imageName  ;
        $image = Image::make($sourcePath);
        $image->fit(300,300);
        $image->save($destPath);

        return response()->json([
            'status'=>true,
            'image_id' => $productsImage->id,
            'ImagePath' => asset('uploads/product/small/'.$productsImage->image),
            'message' =>'image saved successfully'
        ]);
    }
    public function destroy(Request $request){
        $productsImage = productsImage::find($request->id);
        if(empty($productsImage)){
            return response()->json([
                'status'=>false,
                'message'=>'image not found'
            ]);
        }
       
        File::delete(public_path('uploads/product/large/'.$productsImage->image));
        File::delete(public_path('uploads/product/small/'.$productsImage->image));

        $productsImage->delete();
        return response()->json([
            'status'=>true,
            'message'=>'image deleted successfully'
        ]);
    }
}
