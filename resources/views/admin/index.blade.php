@extends('admin.layouts.app')
@section('title','')
@section("admins_active","active")
@section('content')
    <div class="">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header ">
                        <h5>ရောင်းရငွေ</h5>
                    </div>
                    <div class="card-body">
                        <p> ယနေ့ရောင်းရငွေ = <span class="text-muted">{{number_format($dailyTotal)}}(MMK)</span></p>
                        <p>စုစုပေါင်းရောင်းရငွေ = <span class="text-muted">{{number_format($allTotal)}}(MMK)</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h5>စားပွဲအရေအတွက်</h5>
                    </div>
                    <div class="card-body">
                       <h3>{{$tableTotal}}လုံး</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h5>စားဖိုမှုးအရေအတွက်</h5>
                    </div>
                    <div class="card-body">
                       <h3>{{$waiterTotal}}ယောက်</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h5>အမျိုးအစားအရေအတွက်</h5>
                    </div>
                    <div class="card-body">
                       <h3>{{$categoriesTotal}}မျိုး</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h5>အစားသောက်အရအတွက်</h5>
                    </div>
                    <div class="card-body">
                       <h3>{{$dishesTotal}}မျိုး</h3>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection