@extends('app')
@section('title','Thêm user')
@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Create Form</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route("store.category") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="email">Name*:</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nhập name">
                    @error('name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <strong>Parent_ID Process:</strong>
                    <select name="parent_id" class="form-control custom-select">
                      <option value="">Parent_ID Process</option>
                      @foreach($list_category as $category)
                        <option value="{{ $category->id }}"  >{{ $category->name }}</option>
                      @endforeach
                    </select>
                </div>
                <button class="btn btn-success">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
    