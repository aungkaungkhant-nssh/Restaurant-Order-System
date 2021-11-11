@extends('waiter.layouts.app')
@section('order_highlight',"highlight")
@section('content')
   
    <div class="table">
        <div class="row">
            <div class="d-md-flex justify-content-between align-items-center">
                <div class="mb-3">
                    <div class="d-flex d-md-block">
                        <input type="text" placeholder="အစားသောက်ရှာရန်" class="foodsearch" >
                        <button class="btn ml-5" style="background-color:#2ecc71;color:#fff" id="search">
                           <i class="fas fa-search"></i>
                           
                        </button>
                    </div>
                
                </div>
                <div class="mb-3">
                    <select name="table_id" class="form-control" id="table_number">
                        <option value="">စားပွဲနံပါတ်ရွေးချယ်ပါ</option>
                        @foreach ($tables as $table)
                            <option value="{{$table->number}}">{{$table->number}}</option>
                        @endforeach
                    </select>
                </div>
               <div >
                   <a  href="{{url('/order-lists-confirm')}}" class="btn" style="background-color:#2ecc71;color:#fff" ><i class="fas fa-list"></i> တင်ထားသည့်စားရင်းများ
                    <span class="badge bg-danger lists"></span>
                   </a>
               </div>
            </div>
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link @if(!request()->category_id)  active @endif" href="/">အားလုံး</a>
                        </li>
                        @foreach ($categories as $category)
                          <li class="nav-item">
                            <a class="nav-link menu {{request()->category_id==$category->id ? "active" :""}}" href="#" data-id="{{$category->id}}">{{$category->name}}</a>
                          </li>    
                        @endforeach
                      </ul>
                </div>
                <div class="card-body">
                    <div class="dishes-container mt-4">
                        <div class="infinite-scroll">
                            <div class="row">
                                @foreach ($dishes as $dish)
                                 <div class="col-md-4 mt-3">
                                    <div class="card">
                                        <img src="{{asset("storage/dishesImage/$dish->image")}}" alt="" style="width:100%;">
                                        <div class="card-body">
                                            <div class="card-title">
                                                {{$dish->name}}
                                            </div>
                                            <p class="card-text">
                                                {{number_format($dish->price)}} <span class="text-muted">(MMK)</span>
                                            </p>
                                            <button class="btn" style="background-color:#2ecc71;color:#fff" id="dish" data-id={{$dish->id}}>
                                              
                                                <i class="fas fa-pen"></i> တင်ရန်   
                                            </button>
                                            
                                        </div>
                                    </div>
                                 </div>
                                 @endforeach
                                 {{$dishes->links()}}
                              </div>  
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
        <script>
            $(document).ready(function(){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                // $.ajax({
                //     url:'/ssd',
                //     method:"get",
                //     success:function(res){
                //         if(res.status==="success"){
                //             $(".lists").html(res.data)
                //         }
                //     }
                // })
                $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<span>loading...</span>', // MAKE SURE THAT YOU PUT THE CORRECT IMG PATH
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
                });
                $(".menu").on("click",function(e){
                    e.preventDefault()
                   let category_id=$(this).attr("data-id");
                   history.pushState(null,"",`?category_id=${category_id}`);
                   window.location.reload();   
                })
            
                $("#search").click(function(){
                    let foodName= $(".foodsearch").val();
                    history.pushState(null,"",`?foodName=${foodName}`);
                    window.location.reload(); 
                })
                
                $(document).on("click","#dish",function(e){
                    let table_number=$("#table_number").val(); 
                   let dish_id= $(this).attr("data-id")
                    $.ajax({
                        url:`/order-lists`,
                        method:"POST",
                        data:{table_number,dish_id},
                        success:function(res){
                            if(res.status==="success"){
                                $(".lists").text(res.order_lists_count)
                            }
                            if(res.status==="fail"){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'စားပွဲနံပါတ်ထည့်ပေးပါ',     
                                })
                            }
                        }
                    })
                })
                  
                
            })
        </script>
@endsection