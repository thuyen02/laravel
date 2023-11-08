@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Doctors</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('doctors.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        
        <form action="" method="post" name="doctorsForm" id="doctorsForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doctors_code">Mã Bác Sỹ</label>
                                <input type="text"  name="doctors_code" id="doctors_code" class="form-control" placeholder="doctors_code" value="{{ $Doctors->doctors_code }}" >	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doctors_name">Tên của bác sĩ </label>
                                <input type="text" name="doctors_name" id="doctors_name" class="form-control" placeholder="doctors_name"  value="{{ $Doctors->doctors_name }}">	
                                <p></p>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialization">Chuyên ngành của bác sĩ</label>
                                <input type="text" name="specialization" id="specialization" class="form-control" placeholder="specialization"  value="{{ $Doctors->specialization }}">	
                                <p></p>
                            </div>
                        </div>		
                  				  <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="department">Bộ phận hoặc khoa chuyên môn của bác sĩ</label>
                                    <input type="text" name="department" id="department" class="form-control" placeholder="department"  value="{{ $Doctors->department}}">	
                                    <p></p>
                                </div>
                        </div>		
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                               <select name="status" id="status"  class="form-control">
                                    <option {{ ($Doctors->status == 1)? 'selected': '' }}  value="1">Active</option>
                                    <option  {{ ($Doctors->status == 0)? 'selected': '' }} value="0">Block</option>
                            </select>	
                            </div>
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                    <button type="submit"  class="btn btn-primary">Update</button>              
                <a href="{{ route('doctors.index') }}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#doctorsForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("doctors.update",$Doctors->id) }}',
        type:'put',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('doctors.index') }}";
                $("#doctors_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#doctors_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
            if(response['notfound']==true){
                window.location.href="{{ route('doctors.index') }}"
            }
            var errors =response['errors']
            if(errors['doctors_name']){
               $("#doctors_name").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['doctors_name']);
            }else{
                $("#doctors_name").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['doctors_code']){
               $("#doctors_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['doctors_code']);
            }else{
                $("#doctors_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
           
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#doctors_name").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.doctors_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$Doctors_code"].val(response["doctors_code"]);
            }
        }
    });

});
</script>
@endsection