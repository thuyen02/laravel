@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products Detail</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="car-title">
                        <button type="button" onclick="window.location.href='{{ route('products.index') }}'" class="btn btn-default btn-sm" >Làm Mới</button>
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
                <div>
                    
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
        </div>
    </div>
    <!-- /.card -->
</section>
@section('customJs')

<script>
 function deleteProducts(id){
        var url = '{{ route("products.delete","ID") }}';
        var newUrl = url.replace("ID",id);
       if(confirm('bạn có muốn xóa không?')){
        $.ajax({
            url:newUrl,
            type:'delete',
            data: {},
            dataType:'json',       
            success: function(response){
                if(response["status"]){
                    window.location.href="{{ route('products.index') }}";
                }else{
                    window.location.href="{{ route('products.index') }}";
                }
            }
        });
       }
        }
</script>
<!-- /.content -->
@endsection