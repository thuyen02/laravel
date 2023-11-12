@extends('front.layouts.dashboard')

@push('page-styles')
    {{-- - - --}}
@endpush

@section('content')
    <!-- BEGIN: Header -->
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                            Details Product
                        </h1>
                    </div>
                </div>

            
            </div>
        </div>
    </header>

    <div class="container-xl px-2 mt-n10">
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="car-title">
                        <button type="button" onclick="window.location.href='{{ route('product.index') }}'" class="btn btn-default btn-sm" >Làm Mới</button>
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
                            <th width="80"></th>
                            <th>Sản Phẩm</th>
                            <th>Số Lượng Sản Phẩm</th>
                            <th>Mã Sản Phẩm</th>
                            <th>ID Mã Hàng</th>
                            <th>ID Mã Đơn Vị</th>
                            <th>Giá</th>
                            <th>Giá Nhập</th>
                            <th>Giá Bán lẻ</th>
                            <th width="10">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($Products->isNotEmpty())
                        @foreach($Products as $S)
                        @php
                            $productImage = $S->product_images->first();
                        @endphp
                        <tr>
                            <td>{{ $S->id }}</td>
                            <td>
                                @if(!empty($productImage->image))
                                <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" class="img-thumbnail" width="50" >
                                @else
                                <img src="admin-asset/img/default-150x150.png" class="img-thumbnail" width="50" alt="">
                                @endif
                            </td>
                            <td><a href="#">{{ $S->product_name }}</a></td>
                            <td>{{ $S->product_quantity }}</td>
                            <td>{{ $S->product_code }}</td>
                            <td>{{ $S->category_id }}</td>
                            <td>{{ $S->unit_id }}</td>
                            <td>{{ $S->price }}</td>											
                            <td>{{ $S->price_retail }}</td>											
                            <td>{{ $S->price_wholesale }}</td>											
                            <td>
                                @if($S->status == 1)
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
                {{ $Products->links()}}
            </div>
        </div>
    </div>
    <!-- END: Main Page Content -->
@endsection

@push('page-scripts')
  
@endpush
