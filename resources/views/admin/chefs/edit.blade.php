@extends('admin.layouts.app')
@section('title','Edit Waiters')
@section("waiters_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.chef.update',$user->id)}}" method="POST" id="update">
            @method('PUT')
            @csrf
            <div class="form-group mb-2">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{old("name",$user->name)}}">
                
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control" value="{{old("email",$user->email)}}">
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{old("phone",$user->phone)}}">
                @error('phone')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" value="{{old("password")}}">
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Address</label>
                <textarea name="address" class="form-control" >{{old("address",$user->address)}}</textarea>
                @error('address')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <input type="submit" class="btn btn-primary mt-3" value="Edit">
        </form>
    </div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateChefsRequest',"#update") !!}
    <script>
       $(document).ready(function(){
          
       })
    </script>
@endsection