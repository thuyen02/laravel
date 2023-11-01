@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm Mới Nhà Cung Cấp</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('suppiler.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">   
        <form action="" method="post" name="suppilerForm" id="suppilerForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                    
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="suppiler_code">Mã nhà cung cấp</label>
                                <input type="text"  name="suppiler_code" id="suppiler_code" class="form-control" placeholder="suppiler_code">	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="suppiler_name">Tên cung cấp </label>
                                <input type="text" name="suppiler_name" id="suppiler_name" class="form-control" placeholder="suppiler_name">	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number">số điện thoại</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="phone_number">	
                                <p></p>
                            </div>
                        </div>		
                  				  <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email"  name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                <p></p>
                            </div>
                        </div>		
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                               <select name="status" id="status"  class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                            </select>	
                            </div>
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                    <button type="submit"  class="btn btn-primary">Thêm mới</button>              
                <a href="" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#suppilerForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("suppiler.store") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('suppiler.index') }}";
                $("#suppiler_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#suppiler_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
                var errors =response['errors']
            if(errors['suppiler_name']){
               $("#suppiler_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['suppiler_name']);
            }else{
                $("#suppiler_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
       
            if(errors['suppiler_code']){
               $("#suppiler_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['suppiler_code']);
            }else{
                $("#suppiler_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#suppiler_name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.suppiler_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$suppiler_code"].val(response["suppiler_code"]);
            }
        }
    });

});
</script>
@endsection