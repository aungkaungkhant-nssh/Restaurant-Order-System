@extends('waiter.layouts.app')
@section('order_highlight',"highlight")
@section('content')
    <div class="orderlistsconfirm">
        <div class="card">
           <div class="card-header text-center">
                <i class="fas fa-pen" style="color: #2ecc71"></i>
                <h5 style="display: inline-block;margin-left:6px;">မှာထားသည့်စားရင်းများ</h5>
                <p class="table_number">စားပွဲနံပါတ်({{$table_number}})</p>
           </div>
            <div class="card-body text-center">
                @foreach ($order_lists as $order_list)
                    <div class="d-md-flex justify-content-between">
                        <div>
                            <p style="display: inline-block;margin-right:10px;" class="dish_name">{{$order_list->dish->name}}</p>
                            <span class="badge bg-primary" class="dish_count">{{$order_list->count}}</span>
                        </div>
                        <div>
                            <span class="me-3 action"><i class="fas fa-plus-square text-success plus" data-id="{{$order_list->id}}"></i></span>
                            <span class="me-3 action"><i class="fas fa-minus-square text-warning minus" data-id="{{$order_list->id}}"></i></span>
                            <span class="me-3 action"><i class="fas fa-trash fa-1x text-danger delete" data-id="{{$order_list->id}}"></i></span>
                        </div>
                    </div>
                    <hr>
                @endforeach
                <form action="{{url("/order-lists-complete")}}" method="POST">
                    @csrf
                    <input type="hidden" name="table_number" value="{{$table_number}}">
                    <button class="btn ready" style="background-color:#2ecc71;color:#fff; " >သေချာပြီ</button>
                </form>
               
             
                
            </div>
          </div>
    </div>
@endsection
@section('script')
        <script>
            $(document).ready(function(){
               $(document).on("click",".plus",function(){
                  let  increase_order_id=$(this).attr("data-id");
                  $.ajax({
                      url:`/order-list-increase`,
                      method:"POST",
                      data:{increase_order_id},
                      success:function(res){
                        window.location.reload();
                      }
                  })
               })
               $(document).on("click",".minus",function(){
                  let  decrease_order_id=$(this).attr("data-id");
                  $.ajax({
                      url:`/order-list-decrease`,
                      method:"POST",
                      data:{decrease_order_id},
                      success:function(res){
                        window.location.reload();
                      }
                  })
               })
               $(document).on("click",".delete",function(){
                    let  delete_order_id=$(this).attr("data-id");
                    $.ajax({
                      url:`/order-list-delete?delete_order_id=${delete_order_id}`,
                      method:"DELETE",
                      success:function(res){
                        window.location.reload();
                      }
                  })
               })
              
            })
        </script>
@endsection