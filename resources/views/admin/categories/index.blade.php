@extends('admin.layouts.app')
@section('title','အမျိုးအစားများ')
@section("categories_active","active")
@section('content')
    <div class="">
        <a href="{{route("admins.categories.create")}}" class="btn btn-success mb-3">
            <i class="fas fa-plus-circle"></i>
            အသစ်ဖန်တီးမည်
        </a>
        <table class="table table-bordered" id="categories-table">
            <thead>
                <tr>
                    <th>နာမည်</th>
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
           let table= $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admins/categories/datable/ssd',
            order:[["2","desc"]],
            columns: [
                
                { data: 'name', name: 'name' },
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
                            url:`/admins/categories/${id}`,
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