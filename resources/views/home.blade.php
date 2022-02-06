@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <center><div class="card-header"><h3>Online Order System</h3></div></center>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <div class="card-body">
                     @if (session('success_status'))
                        <div class="alert alert-success" role="alert" id="success-alert">
                            {{ session('success_status') }}
                        </div>
                    @endif
                </div>

                    <div class="col-md-8" style="position: relative; left:15%;">
                        <div class="card">
                            @if(Auth()->User()->usertype == 2)
                            <div class="card-body">
                               <center><div class="card-header"><h4>System Admin Role </h4></div></center>
                                <br>
                                <div class="card-body" style="position: relative; left:5%;">
                                    <a href="{{ route('zone.index') }}" class="btn btn-primary">ZONE</a>
                                    <a href="{{ route('region.index') }}" class="btn btn-success">Region</a>
                                    <a href="{{ route('territory.index') }}" class="btn btn-warning">Territory</a>
                                    <a href="{{ route('user.create') }}" class="btn btn-dark">User Create</a>
                                    <a href="{{ route('product.create') }}" class="btn btn-success">Product Create</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="card">
                             <div class="card-body">
                                <center><div class="card-header"><h4>Add and View Orders</h4></div></center>
                                <br>
                                <div class="card-body" style="position:relative; left:20%">
                                    <a href="{{ route('purchaseOrder.create') }}" class="btn btn-primary">Add Purchase Order</a>
                                     <a href="{{ route('purchaseOrder.index') }}" class="btn btn-success">Add Purchase View</a>
                                </div>
                            </div>     
                        </div>
                    </div>


                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
