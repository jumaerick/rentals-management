@include('layouts.app')

@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@php
    
@endphp

<h1>Add Room</h1>

<form action="{{ route('rent.store') }}" method="post">
    @csrf

    <div class="form-group">

        <label for="name"> Select Company</label>
        <select name="company_id" id="company_id">

            <option value="" selected disabled>Select Company</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('company_id'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('company_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">

        <label for="name"> Select Property</label>
        <select name="property_id" id="property_id">

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
        <select name="room_id" id="room_id">

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

    {{-- <p>Rent Date: <input type="text" id="rent_date"></p> --}}

    <div class="form-group">
        <label for="rent_date">Rent Date</label>
        <input type="rent_date" name="rent_date" id="rent_date" value="{{ old('rent_date') }}">
        @if ($errors->has('rent_date'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('rent_date') }}</strong>
            </span>
        @endif

    </div>

    {{-- <div class="form-group">
        <label for="month">Month</label>
        <input type="month" name="month" id="month" value="{{ old('month') }}" class="form-control">
        @if ($errors->has('month'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('month') }}</strong>
            </span>
        @endif

    </div> --}}

    {{-- <div class="form-group">
        <label for="year">Year</label>
        <input type="year" name="year" id="year" value="{{ old('year') }}" class="form-control">
        @if ($errors->has('year'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('year') }}</strong>
            </span>
        @endif

    </div> --}}

    <div class="form-group">
        <label for="deposit">Deposit</label>
        <input type="text" name="deposit" id="deposit" value="{{ old('deposit') }}" >
        @if ($errors->has('deposit'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('deposit') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="text" name="amount" id="amount" value="{{ old('amount') }}">
        @if ($errors->has('amount'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('amount') }}</strong>
            </span>
        @endif

    </div>




    <div class="form-group">
        <button class="btn-success">Create</button>
    </div>
</form>


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
                    "_token": "{{ csrf_token() }}"
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



    $(function() {
    $("#rent_date").datepicker({
        dateFormat: "yy-mm-dd", // Format the date as you need
        defaultDate: new Date(new Date().getFullYear(), new Date().getMonth(), 5), // Default to the 5th of the current month
        beforeShowDay: function(date) {
            // Disable all days except the 5th
            return [date.getDate() === 5, ""];
        },
        onClose: function(dateText, inst) {
            // Automatically set the date to the 5th if the user tries to change it
            var selectedMonth = inst.selectedMonth;
            var selectedYear = inst.selectedYear;
            $(this).datepicker("setDate", new Date(selectedYear, selectedMonth, 5));
        }
    });
});

</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">


