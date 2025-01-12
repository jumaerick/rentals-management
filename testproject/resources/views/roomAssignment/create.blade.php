@extends('layouts.app')
@section('content')
@if (Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">New Assignment</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class='yourform' action="{{ route('roomAssignment.store') }}" method="post" autocomplete="off">
                    @csrf


                    <div class="form-group">

                        <label for="name"> Select Property</label>
                        <select name="property_id" id="property_id" class="form-control">

                            <option value="" selected disabled>Select Property</option>
                            @foreach ($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('property_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('property_id') }}</strong>
                        </span>
                        @endif
                    </div>


                    <div class="form-group">

                        <label for="room_code"> Select Room</label>
                        <select name="room_id" id="room_id" class="form-control">

                            <option value="" selected disabled>Select Room</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_code }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('room_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('room_id') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">

                        <label for="user_id"> Select User</label>
                        <select name="user_id" id="user_id" class="form-control">

                            <option value="" selected disabled>Select User</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('user_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('user_id') }}</strong>
                        </span>
                        @endif
                    </div>




                    <div class="form-group">
                        <button class="btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript"></script>

<script>
    $(document).ready(function() {

        $('#property_id').change(function() {
            var property = $('#property_id').val();
            var updateRoute = "{{ route('property.rooms', ':id') }}";
            updateRoute = updateRoute.replace(':id', property);

            $.ajax({
                url: updateRoute,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: property
                },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        console.log(data);
                        $('#room_id').empty();
                        $('#room_id').append(
                            '<option hidden>Select Room</option>');

                        $.each(data, function(key, room) {

                            $('select[name="room_id"]').append(
                                '<option value="' + room.id + '">' + room
                                .room_code +
                                '</option>');

                        });

                    } else {
                        $('#room_id').empty();
                    }
                }
            });
        });

    });
</script>


@endsection