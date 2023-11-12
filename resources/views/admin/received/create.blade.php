@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm Mới Phiếu Nhập</h1>
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
        <form action="" name="receivedForm" id="receivedForm" method="POST">     
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name">Sản phẩm</label>
                            <select name="product" id="product" class="form-control">
                                <option > Chọn Sản Phẩm</option>
                                @if($Product->isNotEmpty())
                                @foreach($Product as $product  )
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="received_code">Mã phiếu nhập</label>
                            <input type="text" name="received_code" id="received_code" class="form-control" placeholder="Loại Hàng">	
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity">Số Lượng Sản Phẩm</label>
                                    <input type="number" min="0" name="quantity" id="quantity" class="form-control" placeholder="Số lượng sản phẩm">	
                                    <p></p>
                                </div>
                            </div>
                
      
                        </div>	
               
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
            <a href="{{route('received.index')}}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
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
    console.log(element.serializeArray());
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("received.store") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('received.index') }}";
                $("#quantity").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#received_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
                var errors =response['errors']
            if(errors['quantity']){
               $("#quantity").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['received_name']);
            }else{
                $("#quantity").removeClass('is-invalid')
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
            console.log("some thing went wwrong");
        }

    })
});
 
$("#quantity").change(function(){
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
            $["$received_code"].val(response["received_code"]);
            }
        }
    });

});
</script>
@endsection