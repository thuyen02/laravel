@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm Mới Đơn Vị</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('patients.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        
        <form action="" method="post" name="patientsForm" id="patientsForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patients_name">Tên Bệnh Nhân</label>
                                <input type="text" name="patients_name" id="patients_name" class="form-control" placeholder="patients_name">	
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patients_code">Mã Bệnh nhân</label>
                                <input type="text"  name="patients_code" id="patients_code" class="form-control" placeholder="patients_code">	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number">Số Điện Thoại</label>
                                <input type="text"  name="phone_number" id="phone_number" class="form-control" placeholder="phone_number">	
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patients_address">Địa chỉ</label>
                                <input type="text"  name="patients_address" id="patients_address" class="form-control" placeholder="patients_address">	
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
                        </div>	
                        <div class="col-md-6">
    
                              	
                            <div class="mb-3">
                                    <div class="card-body">
                                       <label for="gender	">Giới Tính</label>
                                      <select name="gender" id="gender" class="form-control">
                                          <option value="1">Nam</option>
                                          <option value="0">Nữ</option>
                                      </select>
                                  </div>
                      
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
                <a href="{{ route('patients.index') }}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#patientsForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("patients.store") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('patients.index') }}";
                $("#patients_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#patients_code").removeClass('is-invalid')
               .siblings('p')   
               .removeClass('invalid-feedback').html("");
            }else{
                var errors =response['errors']
            if(errors['patients_name']){
               $("#patients_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['patients_name']);
            }else{
                $("#patients_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['patients_code']){
               $("#patients_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['patients_code']);
            }else{
                $("#patients_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
           
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.patients_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$patients_code"].val(response["patients_code"]);
            }
        }
    });

});
</script>
@endsection