@extends('app')
@section('title','Sửa Category')
@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Update Category</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route("update.category") }}" method="POST" enctype="multipart/form-data">

                @csrf
               
                <input type="hidden"  name="id" value="{{$product_category->id}}">
                <div class="form-group">
                    <label for="email">Name*:</label>
                    <input type="text" value="{{$product_category->name}}" name="name" class="form-control" id="name" placeholder="Nhập name">
                    @error('name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <strong>Parent_ID Process:</strong>
                    <select name="parent_id" class="form-control custom-select">
                      <option value="">Parent_ID Process</option>
                      @foreach($list_category as $category)
                        <option value="{{ $category->id }}" @if($product_category->parent_id == $category->id) selected @endif>{{ $category->name }}</option>
                      @endforeach
                      @error('parent_id')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                    </select>
                </div>
                <button class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
