@extends('app')
@section('title','Đăng ký')
@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Registation Form</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('register.action') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Username:</label>
                    <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Nhập Username">
                    @error('user_name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Nhập Email">
                    @error('email')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Fistname:</label>
                    <input type="text" name="fist_name" class="form-control" id="fist_name" placeholder="Nhập Fistname">
                    @error('fist_name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Lastname:</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Nhập Lastname">
                    @error('last_name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday:</label>
                    <input type="date" class="form-control" name="birthday" id="birthday" placeholder="Nhập Birthday">
                    @error('birthday')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Nhập Password">
                    @error('password')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirmation_pwd">Confirmation Password:</label>
                    <input type="password" name="password_confirm" class="form-control" id="confirmation_pwd" placeholder="Nhập Confirmation Password">
                    @error('password_confirm')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <button class="btn btn-success">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection