@extends('user.master_user')
@section('title', 'Thêm ')
@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Create Form</h2>
            </div>
            <div class="panel-body">
                <form action="{{ route('create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="email">SKU*:</label>
                        <input type="text" name="sku" class="form-control" id="sku" placeholder="Nhập sku">
                        @error('sku')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Name*:</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nhập Name">
                        @error('name')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Image*:</label>
                        <input type="file" name="image" onchange="previewFile(this)" class="form-control image-preview"
                            id="image" placeholder="Nhập Email">
                    </div>

                    <div class="form-group">
                        <label for="email">Stock*:</label>
                        <input type="text" name="stock" class="form-control" id="stock" placeholder="Nhập Stock">
                        @error('stock')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Expired_at*:</label>
                        <input type="date" name="expired_at" class="form-control" id="expired_at"
                            placeholder="Nhập expired_at">
                        @error('expired_at')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <strong>categoryid:</strong>
                        <select name="id" class="form-control custom-select">
                          <option value="">categoryid</option>
                          @foreach($list_category as $category)
                            <option value="{{ $category->id }}"  >{{ $category->id }}</option>
                          @endforeach
                        </select>
                    </div>
                    

                    <button type="button" class="btn btn-primary preview" data-toggle="modal"
                        data-target="#exampleModalCenter">
                        Preview
                    </button>
                    <button class="btn btn-success">Register</button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        SKU:
                                        <h5 name="sku"></h5>
                                    </div>
                                    <div class="row">
                                        Name:
                                        <h5 name="name"></h5>
                                    </div>
                                    <div class="row">
                                        Stock:
                                        <h5 name="stock"></h5>
                                    </div>
                                    <div class="row">
                                        Expired_at:
                                        <h5 name="expired_at"></h5>
                                    </div>
                                    <div class="row">
                                        Ảnh:
                                        <img id="previewImg" src="https://via.placeholder.com/300"
                                            style="max-width: 100%; width:100px">
                                        <script>
                                            function previewFile(input) {
                                                var file = $(".image-preview").get(0).files[0];
                                                if (file) {
                                                    var reader = new FileReader();
                                                    reader.onload = function() {
                                                        $("#previewImg").attr("src", reader.result);
                                                    }
                                                    reader.readAsDataURL(file);
                                                }
                                            }
                                        </script>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $('.preview').click(function() {
            var sku = document.getElementById('sku').value;
            var name = document.getElementById('name').value;
            var stock = document.getElementById('stock').value;
            var expired_at = document.getElementById('expired_at').value;

            $('#exampleModalCenter').find('[name="sku"]').text(sku);
            $('#exampleModalCenter').find('[name="name"]').text(name);
            $('#exampleModalCenter').find('[name="stock"]').text(stock);
            $('#exampleModalCenter').find('[name="expired_at"]').text(expired_at);
        });
    </script>
@endsection
