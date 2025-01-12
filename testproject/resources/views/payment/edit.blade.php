@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Update Payment</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('payment.update', $payment->id) }}" method="post"
                    autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="name"> Select Property</label>
                        <select name="property_id" id="property_id" class = "form-control" required>
                            <option value="" selected disabled>Select Property</option>
                            @foreach ($properties as $property)

                            <option value="{{ $property->id }}" {{($property->id == $payment->rent->room->property_id) ? 'selected' : ''}}>{{ $property->name }}</option>
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
                        <select name="room_id" id="room_id" class = "form-control" required>

                            <option value="" selected disabled>Select Room</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{($room->id == $payment->rent->room->id) ? 'selected' : ''}}>{{ $room->room_code }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('room_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('room_id') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" id="amount" value="{{ $payment->amount }}" class="form-control" required>
                        @if ($errors->has('amount'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('amount') }}</strong>
                        </span>
                        @endif

                    </div>


                    <input type="submit" name="save" class="btn btn-danger" value="Update">
                    <!-- <input type='hidden' name='property_id' value='{{$payment->rent->room->property->property_id}}'> -->
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#company_id').change(function() {
            var company = $('#company_id').val();
            var updateRoute = "{{ route('company.properties', ':id') }}";
            updateRoute = updateRoute.replace(':id', company);


            $.ajax({
                url: updateRoute,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        console.log(data);
                        $('#property_id').empty();
                        $('#property_id').append(
                            '<option hidden>Select Property</option>');

                        $.each(data, function(key, property) {
                            $('select[name="property_id"]').append(
                                '<option value="' + property.id + '">' + property.name +
                                '</option>');
                        
                        });

                    } else {
                        $('#property_id').empty();
                    }
                }
            });
        });

        $('#property_id').change(function() {
            var property = $('#property_id').val();
            var updateRoute = "{{ route('property.rooms', ':id') }}";
            updateRoute = updateRoute.replace(':id', property);


            $.ajax({
                url: updateRoute,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": property
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
                                '<option value="' + room.id + '">' + room.room_code +
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