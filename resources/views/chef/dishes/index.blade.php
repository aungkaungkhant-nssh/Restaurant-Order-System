@extends('chef.layouts.app')
@section('title','အစာသောက်များ')
@section("dishes_active","active")
@section('content')
    <div class="">
        <table class="table table-bordered" id="dishes-table">
            <thead>
                <tr>
                    <th>အမျိုးအစား</th>
                    <th>အမည်</th>
                    <th class="searchable sortable">ဓာတ်ပုံ</th>
                    <th>ဈေးနှုန်း</th>
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
            ajax: '/chefs/dishes/datable/ssd',
            // order:[["4","desc"]],
            columns: [
                {data:'category',name:'category'},
                { data: 'name', name: 'name' },
                { data:'image',name:'image'},
                { data:'price',name:'price'},
                
              
                ],
            "columnDefs": [
                { "sortable": false, "targets": ["sortable"] },
                { "searchable": false, "targets": ["searchable"] }
            ]
            });
          
       })
    </script>
@endsection