@extends('app')
@section('title','Đổi mật khẩu')
@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Change Password</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('password.action') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Nhập Password Old">
                    @error('old_password')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Nhập New Password">
                    @error('new_password')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirmation_pwd">New Confirmation Password:</label>
                    <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="Nhập New Confirmation Password">
                    @error('new_password_confirmation')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <button class="btn btn-success">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection