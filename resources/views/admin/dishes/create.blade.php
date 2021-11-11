@extends('admin.layouts.app')
@section('title','အစားသောက်သစ်များထည့်မည်')
@section("dishes_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.dishes.store')}}" method="POST" id="create" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="">နာမည်</label>
                <input type="text" name="name" class="form-control" value="{{old("name")}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">အမျိုုးအစား</label>
                <select name="category_id" id="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                    <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">ဓာတ်ပုံ</label>
                <div>
                    <input type="file" name="image"  value="{{old("image")}}">
                </div>
               
                @error('image')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">ဈေးနှုန်း</label>
                <input type="text" name="price" class="form-control" value="{{old("price")}}">
                @error('price')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
         
       
            <input type="submit" class="btn btn-primary mt-3" value="ထည့်မည်">
        </form>
    </div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreDishesRequest',"#create") !!}
    <script>
       $(document).ready(function(){
        $('#category').select2();
       })
    </script>
@endsection