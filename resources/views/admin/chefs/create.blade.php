@extends('admin.layouts.app')
@section('title','စားဖိုမှူးအသစ်ထည့်မည်')
@section("waiters_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.chef.store')}}" method="POST" id="create">
            @csrf
            <div class="form-group mb-2">
                <label for="">နာမည်</label>
                <input type="text" name="name" class="form-control" value="{{old("name")}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">အီးမေလ်း</label>
                <input type="text" name="email" class="form-control" value="{{old("email")}}">
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">ဖုန်း</label>
                <input type="text" name="phone" class="form-control" value="{{old("phone")}}">
                @error('phone')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">ပက်စ်ဝေါ့</label>
                <input type="password" name="password" class="form-control" value="{{old("password")}}">
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">နေရပ်လိပ်စာ</label>
                <textarea name="address" class="form-control" >{{old("address")}}</textarea>
                @error('address')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
        <input type="submit" class="btn btn-primary mt-3" value="ထည့်မည်">
        </form>
    </div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreChefsRequest',"#create") !!}
    <script>
       $(document).ready(function(){
          
       })
    </script>
@endsection