@extends('front.layouts.dashboard')

@section('content')
<!-- BEGIN: Header -->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-folder"></i></div>
                        Unit List
                    </h1>
                </div>
                
            </div>

         
        </div>
    </div>

  
</header>

<!-- BEGIN: Main Page Content -->
<div class="container px-4 mt-n10">
    <div class="card mb-4">
        <section class="content-header">					
            <div class="container-fluid my-2">
               
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                @include('admin.message')
                <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="car-title">
                            <button type="button" onclick="window.location.href='{{ route('unitts.index') }}'" class="btn btn-default btn-sm" >Làm Mới</button>
                        </div>
                            <div class="card-tools">
                                <div class="input-group input-group" style="width: 250px;">
                                    <input type="text" value="{{ Request::get('keyworld')}}" name="keyworld" class="form-control float-right" placeholder="Tìm kiếm">
                
                                    <div class="input-group-append">
                                      <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                      </button>
                                    </div>
                                  </div>
                            </div>
        
                        </form>
                    </div>
                    <div class="card-body table-responsive p-0">								
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="60">ID</th>
                                    <th>Mã Đơn vị</th>
                                    <th>Tên Đơn Vị</th>
                                    <th width="1">Trạng Thái</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @if($Unit ->isNotEmpty())
                                @foreach($Unit as $U)
                                <tr>
                                    <td>{{ $U->id }}</td>
                                    <td>{{ $U->unit_code }}</td>
                                    <td>{{ $U->name }}</td>
                                    <td>
                                        @if($U->status == 1)
                                        <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @else
                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @endif
                                    </td>
                                  
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" >records not found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>										
                    </div>
                    <div class="card-footer clearfix">
                        {{ $Unit->links() }}
                        
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
    </div>
</div>
<!-- END: Main Page Content -->
@endsection
