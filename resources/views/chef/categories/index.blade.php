@extends('chef.layouts.app')
@section('title','အမျိုးအစားများ')
@section("categories_active","active")
@section('content')
    <div class="container my-3">
        <table class="table table-bordered" id="categories-table">
            <thead>
                <tr>
                    <th>အမျိုးအစားများ</th>
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
           let table= $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/chefs/categories/datable/ssd',
            // order:[["2","desc"]],
            columns: [
                {data:"name",name:"name"}
                
              
                ],
            "columnDefs": [
                { "sortable": false, "targets": ["sortable"] },
                { "searchable": false, "targets": ["searchable"] }
            ]
            });
         
            
       })
    </script>
@endsection