@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Insert Medicalrecords</h1>
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
        <form action="" name="medicalrecordsForm" id="medicalrecordsForm" method="POST">     
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
                                <option value="{{ $doctors->id }}">{{ $doctors->doctors_name }}</option>
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
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Insert</button>
            <a href="{{route('medicalrecords.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        url:'{{ route("medicalrecords.store") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
        // $("button[type=submit]").prop('disabled',false);
            if(response["status"]==true){
            //     window.location.href="{{ route('medicalrecords.index') }}";
            //     $("#medicalrecords_code").removeClass('is-invalid')
            //    .siblings('p')
            //    .removeClass('invalid-feedback').html("");

            //    $("#medicalrecords_diagnosis").removeClass('is-invalid')
            //    .siblings('p')
            //    .removeClass('invalid-feedback').html("");
            }else{
                var errors =response['errors']
            if(errors['medicalrecords_code']){
               $("#medicalrecords_code").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['medicalrecords_code']);
            }else{
                $("#medicalrecords_code").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
       
            if(errors['medicalrecords_diagnosis']){
               $("#medicalrecords_diagnosis").addClass('is-invalid')
               .siblings('p')
               .addClass('invalid-feedback').html(errors['medicalrecords_diagnosis']);
            }else{
                $("#medicalrecords_diagnosis").removeClass('is-invalid')
               .siblings('p')
               .removeClass('invalid-feedback').html("");
            }
            }
        },error:function(jqXHR, exception){
            console.log("some thing Went wwrong");
        }

    })
});
 
$("#medicalrecords_code").change(function(){
    element =$(this);
    // $("button[type=submit]").prop('disabled',true);

    $.ajax({
    url:'{{ route("Get.medicalrecords_diagnosis") }}',
    type:'get',
    data: {title: element.val()},
    dataType:'json',
    success: function(response){
    // $("button[type=submit]").prop('disabled',false);
        if(response["status"]==true){
            $["$medicalrecords_diagnosis"].val(response["medicalrecords_diagnosis"]);
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