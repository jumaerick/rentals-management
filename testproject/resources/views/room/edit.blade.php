@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Update Room</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('room.update', $room->id) }}" method="post"
                    autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Room Code</label>
                        <input type="text" class="form-control" placeholder="room_code" name="room_code"
                            value="{{ $room->room_code }}" required>
                        @error('room_code')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <input type="submit" name="save" class="btn btn-danger" value="Update">
                    <input type='hidden' name='property_id' value='{{$room->property_id}}'>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection