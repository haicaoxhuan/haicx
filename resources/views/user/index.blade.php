@extends('user.master_user')
@section('title','Danh sách category')
@section('content')
<div class="card">
  @if(session('success'))
  <div class="alert alert-success" role="alert" style="margin-top: 10px; display:none">
    <span>{{ session('success') }}</span>
  </div>
  @endif
  @if(session('error'))
  <div class="alert alert-error" role="alert" style="margin-top: 10px;">
     {{ session('error') }}
  </div>
  @endif
  <div class="card-header">
      <h3 class="card-title">Bordered Table</h3>
      <div class="card-body">
          <table class="table table-bordered">
      </div>
      <thead class="thead-dark">
              <tr>
                  <th scope="col">ID</th>
                  <th scope='col'>User_name</th>
                  <th scope="col">Name</th>
                  <th scope="col">Parent_ID</th>
                  <td>
                    <a href="{{route("create.category")}}" class="btn btn-outline-success">
                        <i class="fas fa-create">Thêm</i>
                    </a>
                </td>
                 
              </tr>
          </thead>
          <tbody>
              @foreach ($products_category as $product_category)<tr id="cate{{ $product_category->id }}">
                  <td>{{$product_category->id}}</td>
                  <td>{{$product_category->users->user_name}}</td>
                  <td>{{$product_category->name}}</td>
                  <td>{{$product_category->parent_id}}</td>
                  <td>
                    <a href="{{route("edit.category",$product_category->id)}}" class="btn btn-sm btn-outline-info btn-block btn-flat">
                        <i class="fas fa-edit"></i>
                    </a>
                  </td>
                  <td><button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $product_category->id }}">
                    Delete
                </button></td>
              </tr> @endforeach
          </tbody>
    </table>
    <div class="pagination pagination-sm m-0 float-right">
      {{$products_category->links('pagination.default')}}
    </div>
<!-- /.content -->
</div>
@endsection

@section('script')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                $(".delete").click(function(e) {
                    e.preventDefault();
                    const id = $(this).attr("data-id");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "delete",
                                url: "user/category/delete",
                                data: {
                                    id: id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType: "json",
                                success: function(response) {
                                    $('#cate' + id).remove();
                                }
                            });
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })
                });
            });
        </script>
         <script>
            
            let message = $(".alert-success span").text()
            if(message.length>0 ){
            
            Swal.fire({

                icon: 'success',
                title: 'ok',
             text: message,

            });
        }
        </script>
    @endsection
