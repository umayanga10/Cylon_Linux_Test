@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header" style="position: relative; left: 10%; width: 1000px; ">

            <h2 class="text-center mb-5 form-heading">User Registration</h2> 
            
            <div class="card-body" style="position:relative; right: 9%;" >
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="name" class="form-label">Name</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="{{ old('name') }}">
                            @error('name')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="nic" class="form-label">NIC</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="nic" name="nic" aria-describedby="nic" value="{{ old('nic') }}">
                            @error('nic')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="address" class="form-label">Address</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="address" name="address" aria-describedby="address" value="{{ old('address') }}">
                            @error('address')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="mobile" class="form-label">Mobile</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="mobile" name="mobile" aria-describedby="mobile" value="{{ old('mobile') }}">
                            @error('mobile')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="email" class="form-label">Email</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="email" value="{{ old('email') }}">
                            @error('email')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="gender" class="form-label">Gender</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <select class="form-select" name="gender" id="gender" >
                                <option value="" readonly>Select Gender</option>
                                <option value="Female">Female</option>    
                                <option value="Male">Male</option>    
                                <option value="Other">Other</option>    
                            </select>
                            @error('gender')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="territory" class="form-label">Territory</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <select class="form-select" name="territory" id="territory">
                                <option value="" readonly>Select Territory</option>
                                @foreach ($allTerritory as $territory)
                                    <option value="{{ $territory->id }}" {{ (old('territory') == $territory->id ? "selected" : "") }} >{{ $territory->territory_code }}</option>    
                                @endforeach

                            </select>
                            @error('territory')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="name" class="form-label">User Name</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="username" name="username" aria-describedby="username" value="{{ old('username') }}">
                            @error('username')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="name" class="form-label">Password</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="password" value="{{ old('password') }}">
                            @error('password')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 mt-5 text-center" style="position:relative; left: 12%;">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    
                </form>
            </div>
    </div>
</div>
@endsection