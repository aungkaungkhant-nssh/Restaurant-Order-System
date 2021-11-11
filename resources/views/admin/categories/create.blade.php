@extends('admin.layouts.app')
@section('title','အမျိုးအစား ဖန်တီးမည်')
@section("categories_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.categories.store')}}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label for="">အမျိုးအစား အမည်</label>
                <input type="text" name="name" class="form-control">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <input type="submit" class="btn btn-primary mt-3" value="ထည့်မည်">
        </form>
    </div>
@endsection
@section('scripts')
    <script>
       $(document).ready(function(){
          
       })
    </script>
@endsection