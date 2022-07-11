@extends('user.master_user')
@section('title', 'Danh sách product')
@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success" role="alert" style="margin-top: 10px; display:none">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error" role="alert" style="margin-top: 10px;">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-header">
            <div class="card-body">
                <table class="table table-bordered">
            </div>
            <form action="{{ route('product-list') }}" method="get">

                <input type="text" name="key" placeholder="Nhập từ khóa cần tìm">&nbsp
                <select name='stock' id="cars">
                    <option value="0"></option>
                    <option value="1">0-10</option>
                    <option value="2">10-100</option>
                    <option value="3">100-200</option>
                    <option value="4">>200</option>
                </select>&nbsp
                <button type="submit">Tìm kiếm</button>
            </form>

            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Name</th>
                    <th scope="col">Stock</th>
                    <th>Image</th>
                    <th scope="col">Expired_at</th>
                    <th scope="col">User_Name</th>
                    <th scope="col">Category</th>
                    <td>
                        <a href="{{ route('view_create_product') }}" class="btn btn-outline-success">
                            <i class="fas fa-create">Create</i>
                        </a>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dowload
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="downloadPdf">PDF</a>
                                <a class="dropdown-item" href="downloadCSV">CSV</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr id="prod{{ $product->id }}">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><img src="{{ asset($product->avatar) }}" alt="" style="width: 50px">
                        </td>
                        <td>{{ $product->expired_at }}</td>
                        <td>{{ $product->users->user_name }}</td>

                        <td>{{ $product->products_category->name }}</td>
                        <td>
                            <a href="{{ route('view_edit_product', $product->id) }}"
                                class="btn btn-outline-info btn-block btn-flat">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>

                        <td><button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $product->id }}">
                                Delete
                            </button></td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            <div class="pagination pagination-sm m-0 float-right">
                {{ $products->links('pagination.default') }}
            </div>
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
                                url: "delete",
                                data: {
                                    id: id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType: "json",
                                success: function(response) {
                                    $('#prod' + id).remove();
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
            if (message.length > 0) {

                Swal.fire({

                    icon: 'success',
                    title: 'ok',
                    text: message,

                });
            }
        </script>
    @endsection
