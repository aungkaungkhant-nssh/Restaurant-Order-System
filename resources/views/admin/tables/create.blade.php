@extends('admin.layouts.app')
@section('title','စားပွဲအသစ်ဖန်တီးမည်')
@section("tables_active","active")
@section('icon')
    <button class="btn btn-secondary mr-2 back" style="border-radius: 100%">
        <i class="fas fa-chevron-left "></i>
    </button>
@endsection
@section('content')
    <div class="">
       
        <form action="{{route('admins.tables.store')}}" method="POST" id="create">
            @csrf
            
            <div class="form-group mb-3">
                <label for="">စားပွဲနံပါတ်</label>
                <input type="text" name="number" class="form-control" value="{{old("number")}}">
                @error('number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary mt-3" value="create">
        </form>
    </div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreTablesRequest',"#create") !!}
    <script>
       $(document).ready(function(){
      
       })
    </script>
@endsection