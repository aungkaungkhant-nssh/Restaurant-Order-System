@extends('admin.layouts.app')
@section('title','Edit Categories')
@section("categories_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.categories.update',$category->id)}}" method="POST">
            @method("PUT")
            @csrf
            <div class="form-group mb-2">
                <label for="">Category Name</label>
                <input type="text" name="name" class="form-control" value="{{old("name",$category->name)}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <input type="submit" class="btn btn-primary mt-3" value="Edit">
        </form>
    </div>
@endsection
@section('scripts')
    <script>
       $(document).ready(function(){
          
       })
    </script>
@endsection