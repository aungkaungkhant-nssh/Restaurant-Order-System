@extends('waiter.layouts.app')
@section('table_highlight',"highlight")
@section('content')
    <div class="table">
        <div class="row">
            @foreach ($tables as $table)
            <div class="col-md-6 mb-3">
                <div class="card" style="border: 1px solid 
                @if($table->status==0) red @endif
                @if($table->status==1) #2ecc71 @endif
                @if($table->status==2) yellow @endif
                ">
                    <div class="card-header">
                       <h4> စားပွဲနံပါတ် ({{$table->number}})</h4>
                    </div>
                    <div class="card-body">
                        @if ($table->status==0)
                            <h5>မအားသေးပါ။</h5>
                        @endif
                        @if ($table->status==1)
                             <h5>အားပြီ။</h5>
                            
                         @endif
                         @if ($table->status==2)
                              <h5>ခနလေးစောင့်ပါ။</h5>
                              
                         @endif
                    </div>
                </div>  
            </div>
                
             @endforeach
        </div>
       
        
    </div>
@endsection