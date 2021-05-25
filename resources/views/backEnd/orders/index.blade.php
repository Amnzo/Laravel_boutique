@extends('backEnd.layouts.master')
@section('title','List Orders')
@section('content')
    <div id="breadcrumb"> <a href="{{url('/admin')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('product.index')}}" class="current">Products</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Orders</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>user</th>
                        <th>Email</th>
                        <th>Date Order</th>
                        <th>City</th>
                        <th>Mobile</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Details</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)

                        <tr class="gradeC">
                            <td>{{$order->id}}</td>
                            <td style="vertical-align: middle;">{{$order->user->name}}</td>
                            <td style="vertical-align: middle;">{{$order->user->email}}</td>
                            <td style="vertical-align: middle;">{{$order->created_at->diffForHumans()}}</td>
                            
                            <td style="vertical-align: middle;">{{$order->city}}</td>
                            <td style="vertical-align: middle;">{{$order->mobile}}</td>
                            <td style="vertical-align: middle;text-align: center;"><a href="#" class="btn btn-default btn-mini">{{$order->grand_total}}</a></td>
                            <td style="vertical-align: middle;text-align: center;">
                            @if($order->order_status =='cancel')
                            
                                <a href="#" class="btn btn-danger btn-mini">
                                                
                            @elseif ($order->order_status =='waiting')
                                <a href="#" class="btn btn-warning btn-mini">
                            @else
                                  <a href="#" class="btn btn-success btn-mini">
                            
                            @endif

                            
                            {{$order->order_status}}</a></td>
                            <td style="text-align: center; vertical-align: middle;">
                            
                                <a href="{{route('more',$order->id)}}"  class="btn btn-info btn-mini">View</a>
                                <form action="{{ route('soft', 5) }}" method="post">
                                    <input class="btn btn-default" type="submit" value="Delete" />
                                    <input type="hidden" name="_method" value="delete" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form> 
                                
                            </td>
                        </tr>
                       
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.ui.custom.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.uniform.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/matrix.js')}}"></script>
    <script src="{{asset('js/matrix.tables.js')}}"></script>
    <script src="{{asset('js/matrix.popover.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(".deleteRecord").click(function () {
            var id=$(this).attr('rel');
            var deleteFunction=$(this).attr('rel1');
            swal({
                title:'Are you sure?',
                text:"You won't be able to revert this!",
                type:'warning',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                confirmButtonText:'Yes, delete it!',
                cancelButtonText:'No, cancel!',
                confirmButtonClass:'btn btn-success',
                cancelButtonClass:'btn btn-danger',
                buttonsStyling:false,
                reverseButtons:true
            },function () {
                window.location.href="/admin/"+deleteFunction+"/"+id;
            });
        });
    </script>
@endsection