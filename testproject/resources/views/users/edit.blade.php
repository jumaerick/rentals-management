@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Update user</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('user.update', $user->id) }}" method="post"
                    autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Names</label>
                        <input type="text" class="form-control" placeholder="name" name="name"
                            value="{{ $user->name }}" required>
                        @error('name')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email"
                            value="{{ $user->email }}" required>
                        @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" placeholder="location" name="location"
                            value="{{ $user->profile ? $user->profile->location : '' }}" required>
                        @error('location')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                @if ($user->gneder == 'male')
                                    <option value="male" selected>Male</option>
                                @else
                                    <option value="female" selected>Female</option>
                                @endif
                            </select>
                            @error('gender')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> -->
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number"
                            value="{{ $user->profile ? $user->profile->phone_number : '' }}" required>
                        @error('phone_number')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <input type="submit" name="save" class="btn btn-danger" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection