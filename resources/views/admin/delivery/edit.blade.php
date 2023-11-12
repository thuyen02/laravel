@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cập Nhật Phiếu Xuất</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('delivery.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        
        <form action="" method="post" name="deliveryForm" id="deliveryForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                    
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="delivery_code">Mã Phiếu Xuất</label>
                                <input type="text"  name="delivery_code" id="delivery_code" class="form-control" placeholder="delivery_code" value="{{ $Delivery->delivery_code }}" >	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity">Số lượng </label>
                                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="quantity"  value="{{ $Delivery->quantity }}">	
                                <p></p>
                            </div>
                        </div>	
                  				  <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id">Mã Sản Phẩm</label>
                                <select class="form-control" disabled >
                                    <option > Chọn Sản Phẩm</option>
                                    @if($Product->isNotEmpty())
                                    @foreach($Product as $product  )
                                    <option {{ ($Delivery->products_id == $product->id)? 'selected' : '' }} value="{{ $product->id }}">{{ $product->id }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="product" id="product"  value="{{ $Delivery->products_id }}" />
                                <p></p>
                            </div>
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                    <button type="submit"  class="btn btn-primary">Update</button>              
                <a href="{{ route('delivery.index') }}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#deliveryForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("delivery.update",$Delivery->id) }}',
        type:'put',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('delivery.index') }}";
                $("#delivery_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#delivery_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
            if(response['notfound']==true){
                window.location.href="{{ route('delivery.index') }}"
            }
            var errors =response['errors']
            if(errors['delivery_name']){
               $("#delivery_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['delivery_name']);
            }else{
                $("#delivery_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['delivery_code']){
               $("#delivery_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['delivery_code']);
            }else{
                $("#delivery_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
           
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#delivery_name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.delivery_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$Delivery_code"].val(response["delivery_code"]);
            }
        }
    });

});
</script>
@endsection