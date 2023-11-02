@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="product.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
    <form action="" name="productsForm" id="productsForm" method="post" >   
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Pricing</h2>								
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="product_quantity">Số Lượng Sản Phẩm</label>
                                    <input type="number" min="0" name="product_quantity" id="product_quantity" class="form-control" placeholder="Số lượng sản phẩm">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="product_name">Tên Sản Phẩm</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="product_name">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="product_code">Mã Sản Phẩm</label>
                                    <input type="text" name="product_code" id="product_code" class="form-control" placeholder="product_code">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price">Giá Nhập</label>
                                    <input type="number" min="0" name="price" id="price" class="form-control" placeholder="Giá nhập">	
                                    <p></p>
                                </div>
                            </div>      
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price_retail">Giá Bán Lẻ</label>
                                    <input type="number" min="0" name="price_retail" id="price_retail" class="form-control" placeholder="Giá bán lẻ">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price_wholesale">Giá Bán Sỉ</label>
                                    <input type="number" min="0" name="price_wholesale" id="price_wholesale" class="form-control" placeholder="Giá bán sỉ">	
                                    <p></p>
                                </div>
                            </div>                                           
                        </div>
                    </div>	                                                                      
                </div>
              
                <div class="card mb-3">
                   <label for="image">Image</label>   
                   <div id="image" class="dropzone dz-clickable">
                    <div class="dz-message needsclick">    
                        <br>Drop files here or click to upload.<br><br>                                            
                    </div>
                </div>                                                             
                </div>
             <div class="row" id="product-gallery">
                
             </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">	
                        <h2 class="h4 mb-3">Trạng Thái Mặt Hàng</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Đang Bán</option>
                                <option value="0">Tạm Dừng</option>
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="card">
                    <div class="card-body">	
                        <h2 class="h4  mb-3">Loại Hàng</h2>
                        <div class="mb-3">
                            <label for="Products">Loại hàng</label>
                          
                            <select name="category" id="category" class="form-control">
                                <option > Chọn Loại Hàng</option>
                                @if($Category->isNotEmpty())
                                @foreach($Category as $category  )
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category">Đơn Vị</label>
                              <select name="unit" id="unit" class="form-control">
                                <option > Chọn Đơn Vị</option>
                                @if($Unit->isNotEmpty())
                                @foreach($Unit as $unit  )
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div> 
                                           
            </div>
        </div>
        
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content
/.content -->
@endsection
@section('customJs')
<script>
     $("#productsForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("products.store") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('products.index') }}";
                $("#products_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#products_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
                var errors =response['errors']
            if(errors['product_name']){
               $("#product_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['product_name']);
            }else{
                $("#product_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['price']){
               $("#price").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['price']);
            }else{
                $("#product_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['product_code']){
               $("#product_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['product_code']);
            }else{
                $("#product_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
          
            
            }
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});
 
$("#product_name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.product_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$product_code"].val(response["product_code"]);
            }
        }
    });

});
Dropzone.autoDiscover = false;    
const dropzone = $("#image").dropzone({ 
    url:  "{{ route('temp-images.create') }}",
    maxFiles: 10,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }, success: function(file, response){
        //$("#image_id").val(response.image_id);
        //console.log(response)
      var html =` <div class="col-md-3" id="image-row-${response.image_id}" "><div class="card" >
        <input type="hidden" name="image_array[]" value="${response.image_id}">
        <img src="${response.ImagePath}" class="card-img-top" alt="">
        <div class="card-body">
            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-primary">Delete</a>
        </div>
        </div>`
        $("#product-gallery").append(html);
    },
    complete: function(file){
        this.removeFile(file);
    }
});
function deleteImage(id){
    $("#image-row-"+id).remove();
}
</script>
@endsection
{{-- if(errors['price']){
    $("#price").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback').html(errors['price']);
 }else{
     $("#price").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback').html("");
 }
 if(errors['price_retail']){
    $("#price_retail").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback').html(errors['price_retail']);
 }else{
     $("#price_retail").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback').html("");
 }
 if(errors['price_wholesale']){
    $("#price_wholesale").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback').html(errors['price_wholesale']);
 }else{
     $("#price_wholesale").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback').html("");
 } --}}