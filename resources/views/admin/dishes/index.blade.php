@extends('admin.layouts.app')
@section('title','အစာသောက်များ')
@section("dishes_active","active")
@section('content')
    <div class="">
        <a href="{{route("admins.dishes.create")}}" class="btn btn-success mb-3">
            <i class="fas fa-plus-circle"></i>
            အသစ်ဖန်တီးမည်
        </a>
        <table class="table table-bordered" id="dishes-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th class="searchable sortable">Image</th>
                    <th>Price</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th class="searchable sortable">Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
       $(document).ready(function(){
           let table= $('#dishes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admins/dishes/datable/ssd',
            order:[["4","desc"]],
            columns: [
                {data:'category',name:'category'},
                { data: 'name', name: 'name' },
                { data:'image',name:'image'},
                { data:'price',name:'price'},
                {data:"created_at",name:"created_at"},
                {data:"updated_at",name:"updated_at"},
                {data:"action",name:"action"}
              
                ],
            "columnDefs": [
                { "sortable": false, "targets": ["sortable"] },
                { "searchable": false, "targets": ["searchable"] }
            ]
            });
            $(document).on("click","#delete",function(e){
                e.preventDefault();
                let id=e.target.dataset.id;
                Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'confirm',
                reverseButtons:true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:`/admins/dishes/${id}`,
                            method:"DELETE",
                            success:function(res){
                                table.ajax.reload();
                            }
                        })
                    }
                })
               
            })
       })
    </script>
@endsection