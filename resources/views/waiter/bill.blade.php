@extends('waiter.layouts.app')
@section('bill_highlight',"highlight")
@section('content')
    <div class="container">
        <div class="row">
            
            @foreach ($table_numbers as $table)
                @php
                $total=0;   
                @endphp
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>စားပွဲနံပါတ် ({{$table}})</h6>
                        </div>
                        <div class="card-body">
                            @foreach ($bills as $bill)
                                    @if($table==$bill->table_number)
                                    @php
                                    $total+=$bill->dish->price * $bill->count
                                    @endphp
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="card-text">{{$bill->dish->name}} <span class="badge bg-danger">{{$bill->count}}</span></p>
                                            </div>
                                            <p class="text-muted" style="font-size:14px">{{number_format($bill->dish?$bill->dish->price * $bill->count :"0")}} <span>(MMK)</span></p>
                                        </div> 
                                        
                                        <hr>  
                                    @else
                                   
                                    @endif
                                        
                            @endforeach
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted">စုစုပေါင်းကျသင့်ငွေ</p> 
                                </div>
                                 <p class="text-success" style="font-size:12px">{{number_format($total)}} <span>(MMK)</span></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div></div>
                                <form action="/billclear" method="POST" id="form-{{$table}}">
                                    @csrf
                                    <input type="hidden" value={{$table}} name="table_number">
                                    <input type="hidden" value="{{$total}}" name="total">
                                    <button class="btn btn-sm billclear" type="submit" style="background-color:#2ecc71;color:#fff" id="dish" data-id="{{$table}}">         
                                        <i class="fas fa-wallet"></i>
                                        <span class="ms-1">ငွေရှင်းမည် </span>
                                    </button>
                                </form>
                               
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
        <script>
            $(document).ready(function(){
                $(document).on("click",".billclear",function(e){
                    e.preventDefault();
                    let formid=$(this).attr("data-id");
                    Swal.fire({
                title: 'သေချာပြီလား။',
                text: "ငွေရှင်းရန်သေချာပြီးလား!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'သေချာပြီ။',
                cancelButtonText: 'မသေချာသေးပါ။',
                reverseButtons:true
                }).then((result) => {
                    if (result.isConfirmed) {
                       $(`#form-${formid}`).submit();
                    }
                })
                })
            })
        </script>
@endsection