@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('medicalrecords.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        
        <form action="" method="post" name="medicalrecordsForm" id="medicalrecordsForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="doctors_name">Doctors</label>
                                <select name="doctors" id="doctors" class="form-control">
                                    <option > Chọn Bác sỹ</option>
                                    @if($Doctors->isNotEmpty())
                                    @foreach($Doctors as $doctors  )
                                    <option {{ ($Medicalrecords->$doctors_id == $$doctors->id)? 'selected' : '' }} value="{{ $doctors->id }}">{{ $doctors->doctors_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="patients_name">Patients</label>
                                <select name="patients" id="patients" class="form-control">
                                    <option > Chọn Bệnh Nhân</option>
                                    @if($Patients->isNotEmpty())
                                    @foreach($Patients as $patients  )
                                    <option value="{{ $patients->id }}">{{ $patients->patients_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicalrecords_code">Medicalrecords Code</label>
                                <input type="text" name="medicalrecords_code" id="medicalrecords_code" class="form-control" placeholder="Loại Hàng">	
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicalrecords_diagnosis">Medicalrecords Diagnosis</label>
                                <input type="text" name="medicalrecords_diagnosis" id="medicalrecords_diagnosis" class="form-control" placeholder="Mã Loại Hàng">
                                <p></p>	
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicalrecords_treatment">Medicalrecords Treatment</label>
                                <input type="text" name="medicalrecords_treatment" id="medicalrecords_treatment" class="form-control" placeholder="medicalrecords_treatment">
                                <p></p>	
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicalrecords_prescription">Medicalrecords Prescription</label>
                                <input type="text" name="medicalrecords_prescription" id="medicalrecords_prescription" class="form-control" placeholder="medicalrecords_prescription">
                                <p></p>	
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicalrecords_date">Medicalrecords Date</label>
                                <input type="date" name="medicalrecords_date" id="medicalrecords_date" class="form-control" placeholder="medicalrecords_prescription">
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
            </div>
            <div class="pb-5 pt-3">
                    <button type="submit"  class="btn btn-primary">Update</button>              
                <a href="{{ route('medicalrecords.index') }}" class="btn btn-outline-dark ml-3">Hủy bỏ</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
$("#medicalrecordsForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    // $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("medicalrecords.update",$MedicalRecords->id) }}',
        type:'put',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
                window.location.href="{{ route('medicalrecords.index') }}";
                $("#medicalrecords_diagnosis").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");

               $("#medicalrecords_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }else{
            if(response['notfound']==true){
                window.location.href="{{ route('medicalrecords.index') }}"
            }
            var errors =response['errors']
            if(errors['medicalrecords_diagnosis']){
               $("#medicalrecords_diagnosis").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['medicalrecords_diagnosis']);
            }else{
                $("#medicalrecords_diagnosis").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            if(errors['medicalrecords_code']){
               $("#medicalrecords_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['medicalrecords_code']);
            }else{
                $("#medicalrecords_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
           
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});

$("#medicalrecords_diagnosis").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.medicalrecords_code") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$medicalrecords_code"].val(response["medicalrecords_code"]);
            }
        }
    });

});
</script>
@endsection