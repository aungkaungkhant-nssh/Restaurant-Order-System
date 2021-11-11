@extends('admin.layouts.app')
@section('title','စားပွဲများ')
@section("tables_active","active")
@section('content')
    <div class="">
        <a href="{{route("admins.tables.create")}}" class="btn btn-success mb-3">
            <i class="fas fa-plus-circle"></i>
            စားပွဲအသစ် ထပ်ထည့်မည်
        </a>
        <table class="table table-bordered" id="categories-table">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Status</th>
                    <th>Created_at</th>
                   
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
            ajax: '/admins/tables/datable/ssd',
            // order:[["2","desc"]],
            columns: [
                
                { data: 'number', name: 'number' },
                { data: 'status', name: 'status' },
                {data:"created_at",name:"created_at"},
             
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
                            url:`/admins/tables/${id}`,
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