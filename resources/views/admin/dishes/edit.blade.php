@extends('admin.layouts.app')
@section('title','Edit  Dishes')
@section("categories_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.dishes.update',$dish->id)}}" method="POST" enctype="multipart/form-data">
            @method("PUT")
            @csrf
            <div class="form-group mb-2">
                <label for="">Dish Name</label>
                <input type="text" name="name" class="form-control" value="{{old("name",$dish->name)}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Category</label>
                <select name="category_id" id="category" class="form-control">
                    @foreach ($categories as $category)
                    <option value={{$category->id}} {{$category->id==$dish->id?"selected":""}}>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Image</label>
                <div>
                    <input type="file" name="image" value="{{old("image")}}" >
                </div>
              
                <div class="my-2">
                    <img src="{{asset("storage/dishesImage/".$dish->image)}}" alt="" style="width: 200px;
                     border-radius: 10px">
                </div>
                
                @error('image')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <div>
            <div class="form-group mb-2">
                <label for="">Price</label>
                <input type="text" name="price" class="form-control" value="{{old("price",$dish->price)}}">
                @error('price')
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
        $('#category').select2();
       })
    </script>
@endsection