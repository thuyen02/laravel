@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cập Nhật Phiếu Nhập</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('received.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        
        <form action="" method="post" name="receivedForm" id="receivedForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                    
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="received_code">Mã Phiếu Nhập</label>
                                <input type="text"  name="received_code" id="received_code" class="form-control" placeholder="received_code" value="{{ $Received->received_code }}" >	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity">Số lượng </label>
                                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="quantity"  value="{{ $Received->quantity }}">	
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
                                    <option {{ ($Received->products_id == $product->id)? 'selected' : '' }} value="{{ $product->id }}">{{ $product->id }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="product" id="product"  value="{{ $Received->products_id }}" />
                                <p></p>
                            </div>
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                    <button type="submit"  class="btn btn-primary">Update</button>              
                <a href="{{ route('received.index') }}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#receivedForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("received.update",$Received->id) }}',
        type:'put',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('received.index') }}";
                $("#received_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#received_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
            if(response['notfound']==true){
                window.location.href="{{ route('received.index') }}"
            }
            var errors =response['errors']
            if(errors['received_name']){
               $("#received_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['received_name']);
            }else{
                $("#received_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['received_code']){
               $("#received_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['received_code']);
            }else{
                $("#received_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
           
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#received_name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.received_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$Received_code"].val(response["received_code"]);
            }
        }
    });

});
</script>
@endsection