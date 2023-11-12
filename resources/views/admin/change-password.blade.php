@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Change Password</h1>
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
        @include('admin.message')
        <form action="" name="changePassword" id="changePassword" method="POST">     
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="category_name">Old Password</label>
                            <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Mật khẩu cũ">	
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="category_name">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Mật khẩu mới">	
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="category_name">Comfirm Password</label>
                            <input type="password" name="comfirm_password" id="comfirm_password" class="form-control" placeholder="Nhập lại mật khẩu mới">	
                            <p></p>
                        </div>
                    </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update</button>
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
   $("#changePassword").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("admin.proccessChangePassword") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('admin.showChangePasswordForm') }}";
                $("#category_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#category_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
                var errors =response['errors'];
                if(errors['old_password']){
                    $("#old_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['old_password']);
                    }else{
                        $("#old_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                }
        
                if(errors['new_password']){
                    $("#new_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['new_password']);
                    }else{
                        $("#new_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                }
                if(errors['comfirm_password']){
                    $("#comfirm_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['comfirm_password']);
                    }else{
                        $("#comfirm_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                }
            }
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});
 

</script>
@endsection 