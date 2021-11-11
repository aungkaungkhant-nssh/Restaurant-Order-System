@extends('waiter.layouts.app')
@section('detail_highlight',"highlight")
@section('content')
    <div class="container">
        <div class="row">
            <div class="card notibox" >
                @foreach ($details_notifications as  $dn)
                <div class="card my-2">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="
                                @if($dn->data["status"]==1)
                                   {{"text-success"}}
                                @elseif($dn->data["status"]==2)
                                {{"text-warning"}}
                                @else
                                {{"text-danger"}}
                                @endif
                            my-2"  style="display: inline-block;margin-left:10px;">{{$dn->data["title"]}}</h6>
                        </div>
                        <span><i class="fas fa-bell text-warning"></i></span>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted my-2">{{$dn->data["messsage"]}}</p>
                    </div>
                </div>
                @endforeach
            </div>
           
        </div>
    </div>
@endsection