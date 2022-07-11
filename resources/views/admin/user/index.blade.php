@extends('admin.master')
@section('title', 'Danh sách user')
@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success" role="alert" style="margin-top: 10px; display:none">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error" role="alert" style="margin-top: 10px;">
                {{ session('error') }}!
            </div>
        @endif
        <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
            <div class="card-body">
                <table class="table table-bordered">
            </div>
            <form action="{{ route('user') }}" method="get">
                <input type="text" name="key" placeholder="Nhập từ khóa cần tìm">&nbsp
                <button type="submit">Tìm kiếm</button>
            </form>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th>Image</th>
                    <th scope="col">User_name</th>
                    <th scope="col">Birthday</th>
                    <th scope="col">Fist_name</th>
                    <th scope="col">Last_name</th>
                    <th scope="col">Status</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr id="use{{ $user->id }}">
                        <td>{{ $user->id }}</td>
                        <td style="width: 50px">{{ $user->email }}</td>
                        <td><img src="{{ asset($user->avatar) }}" alt="" style="width: 50px"></td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->birthday }}</td>
                        <td>{{ $user->fist_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>
                            @if ($user->status == STATUS_ACTIVE)
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route("edit.user",$user->id)}}"
                                class='fa fa-edit' style='color: blue'>
                            </a>
                        </td>
                        <td><a href="" class='fa fa-trash delete' style='color: red' data-id="{{ $user->id }}"></a></td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                {{ $users->links('pagination.default') }}
            </ul>
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
                                url: "user/delete",
                                data: {
                                    id: id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType: "json",
                                success: function(response) {
                                    $('#use' + id).remove();
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
            if(message.length > 0 ){
            
            Swal.fire({

                icon: 'success',
                title: 'ok',
             text: message,

            });
        }
        </script>
    @endsection

