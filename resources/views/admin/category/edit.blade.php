@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cập Nhật Loại Hàng</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        
        <form action="" method="post" name="categoryForm" id="categoryForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                    
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_code">Mã Loại Hàng</label>
                                <input type="text"  name="category_code" id="category_code" class="form-control" placeholder="category_code" value="{{ $Category->category_code }}" >	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_name">Tên Loại Hàng </label>
                                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="category_name"  value="{{ $Category->category_name }}">	
                                <p></p>
                            </div>
                        </div>	
                  				  <div class="col-md-6">
                            <div class="mb-3">
                                <label for="suppiler_id">ID Nhà Cung Cấp</label>
                                <select name="suppiler" id="suppiler" class="form-control">
                                    <option > Chọn Nhà Cung cấp</option>
                                    @if($Suppiler->isNotEmpty())
                                    @foreach($Suppiler as $suppiler  )
                                    <option {{ ($Category->suppiler_id == $suppiler->id)? 'selected' : '' }} value="{{ $suppiler->id }}">{{ $suppiler->suppiler_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>		
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                               <select name="status" id="status"  class="form-control">
                                    <option {{ ($Category->status == 1)? 'selected': '' }}  value="1">Active</option>
                                    <option  {{ ($Category->status == 0)? 'selected': '' }} value="0">Block</option>
                            </select>	
                            </div>
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                    <button type="submit"  class="btn btn-primary">Update</button>              
                <a href="{{ route('category.index') }}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#categoryForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("category.update",$Category->id) }}',
        type:'put',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('category.index') }}";
                $("#category_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#category_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
            if(response['notfound']==true){
                window.location.href="{{ route('category.index') }}"
            }
            var errors =response['errors']
            if(errors['category_name']){
               $("#category_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['category_name']);
            }else{
                $("#category_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['category_code']){
               $("#category_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['category_code']);
            }else{
                $("#category_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
           
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#category_name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.category_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$Category_code"].val(response["category_code"]);
            }
        }
    });

});
</script>
@endsection