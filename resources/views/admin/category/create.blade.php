@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm Mới Loại Hàng</h1>
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
        <form action="" name="categoryForm" id="categoryForm" method="POST">     
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="suppiler_name">Nhà Cung Cấp</label>
                            <select name="suppiler" id="suppiler" class="form-control">
                                <option > Chọn Nhà Cung cấp</option>
                                @if($Suppiler->isNotEmpty())
                                @foreach($Suppiler as $suppiler  )
                                <option value="{{ $suppiler->id }}">{{ $suppiler->suppiler_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_name">Tên Loại Hàng</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Loại Hàng">	
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_code">Mã Loại Hàng</label>
                            <input type="text" name="category_code" id="category_code" class="form-control" placeholder="Mã Loại Hàng">
                            <p></p>	
                        </div>
                    </div>	
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image">Image</label>   
                            <input type="hidden" id="image_id" name="image_id" value="">
                            <div id="image" class="dropzone dz-clickable">            
                                <div class="dz-message needsclick">    
                                <br>Drop files here or click to upload.<br><br>                                            
                                </div>
                            </div>    
                        </div>
                    </div>	
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                           <select name="status" id="status"  class="form-control">
                                <option  value="1">Active</option>
                                <option  value="0">Block</option>
                        </select>	
                        </div>
                    </div>	
      
                        </div>	
               
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
            <a href="{{route('category.index')}}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
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
        url:'{{ route("category.store") }}',
        type:'post',
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
            $["$category_code"].val(response["category_code"]);
            }
        }
    });

});
Dropzone.autoDiscover = false;    
const dropzone = $("#image").dropzone({ 
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url:  "{{ route('temp-images.create') }}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }, success: function(file, response){
        $("#image_id").val(response.image_id);
        //console.log(response)
    }
});
</script>
@endsection