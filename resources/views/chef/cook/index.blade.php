@extends('chef.layouts.app')
@section('title','ချက်ပြုတ်ရမည့် အစားအစာများ')
@section("cookorders_active","active")
@section('content')
    <div class="container my-3">
        <table class="table table-bordered" id="cooks-table">
            <thead>
                <tr>
                 
                    <th>စားပွဲနံပါတ်</th>
                    <th>အမည်</th>
                    <th class="searchable sortable">အရေအတွက်</th>
                    <th>လက်ခံသည်</th>
                    <th>ငြင်းပယ်သည်</th>
                    <th>စောင့်ခိုင်းသည်</th>
                    <th>ရပြီ</th>
                    <th>ရက်စွဲ</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@section('scripts')
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
           let table= $('#cooks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/chefs/cooks/datable/ssd',
            // order:[["2","desc"]],
            columns: [
                
                { data: 'table_number', name: 'table_number' },
                {data:"name",name:'name'},
                {data:"count",name:"count"},
                {data:"accept",name:"accept"},
                {data:"reject",name:"reject"},
                {data:"pending",name:"pending"},
                {data:"ready",name:"ready"},
                {data:"created_at",name:"created_at"}
              
                ],
            "columnDefs": [
                { "sortable": false, "targets": ["sortable"] },
                { "searchable": false, "targets": ["searchable"] }
            ]
            });
            $(document).on("click","#reject",function(e){
                e.preventDefault();
                let id=e.target.dataset.id;
                Swal.fire({
                    title: 'ငြင်းပယ်ရသည့်အကြောင်းအရင်း',
                    icon: 'info',
                    html:'<input type="text" class="form-control text-center message"></input>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    reverseButtons:true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let message=$(".message").val();
                        $.ajax({
                            url:`/chefs/cooks/reject?id=${id}&message=${message}`,
                            method:"GET",
                            success:function(res){
                               if(res.status==="success"){
                                table.ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                 })
                               }
                            }
                        })
                    }
                })
               
            })
            $(document).on("click","#accept",function(e){
                e.preventDefault();
                let id=e.target.dataset.id;
                $.ajax({
                        url:`/chefs/cooks/accept?id=${id}`,
                        method:"GET",
                        success:function(res){
                            if(res.status=="success"){
                                Toast.fire({
                                icon: 'success',
                                title: 'အစားသောက်ကိုလက်ခံလိုက်သည်'
                                })
                            }
                            
                        }
                    })
               
            })
            $(document).on("click","#ready",function(e){
                e.preventDefault();
                let id=e.target.dataset.id;
                Swal.fire({
                title: 'သေချာပြီလား။',
                text: "အစားသောက်တွေအဆင်သင့်ဖြစ်တာသေချာပြီလား!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'သေချာပြီ။',
                cancelButtonText: 'မသေချာသေးပါ။',
                reverseButtons:true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:`/chefs/cooks/ready?id=${id}`,
                            method:"GET",
                            success:function(res){
                              
                                table.ajax.reload();
                            }
                        })
                    }
                })
               
          
                
               
            })
            $(document).on("click","#pending",function(e){
                e.preventDefault();
                let id=e.target.dataset.id;
                $.ajax({
                        url:`/chefs/cooks/pending?id=${id}`,
                        method:"GET",
                        success:function(res){
                            if(res.status=="success"){
                                Toast.fire({
                                icon: 'success',
                                title: 'စောာင့်ခိုင်းလိုက်သည်'
                                })
                            }
                            
                        }
                    })
               
            })
       })
    </script>
@endsection