<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Management</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap (optional) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-actions {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>

<body>

    @php
    use Illuminate\Support\Carbon;

        // dd(Carbon::now()->format('Y-m-d'));
    @endphp
    <div class="container mt-5">
        <h2>Rent payment status</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Property Name</th>
                    <th>Room Code</th>
                    <th>Deposit</th>
                    <th>Rent Amount</th>
                    <th>Rent Date</th>
                    {{-- <th>Actions</th> --}}

                </tr>
            </thead>
            <tbody id="table-body">

                @foreach ($rooms as $room)
                @php
$at = Carbon::parse($room->updated_at)->format('Y-m'); // Parses updated_at as a Carbon instance
$cl = Carbon::now()->format('Y-m'); // Gets the current date in the specified format

// Calculate the date difference
$dateDiff = Carbon::parse($cl)->diffInMonths(Carbon::parse($at)) + 1; // Use diffInDays for an integer difference

// dd($dateDiff); // Dump the difference
                @endphp
                    <tr data-id="{{ $room->id }}">

                        
                        <td> {{ $room->id }}</td>
                        <td>{{ $room->room->property->name }}</td>
                        <td>{{ $room->room->room_code }}</td>
                        <td>{{ $room->room->rent->deposit ?? '' }}</td>
                        <td>{{ $room->room->rent->amount ?? ''}}</td>
                        <td>{{ $room->updated_at}}</td>

                        {{-- <td>
                            <div class="table-actions">
                                <form id="delete-property" action="{{ route('room.destroy') }}" method="POST"
                                    style="display: none;">
                                    <input type="hidden" name="property-id" value="{{ $room->id }}"
                                        id="property-id">
                                    @csrf
                                </form>

                                <form id="update-property" action="{{ route('room.update') }}" method="POST"
                                    style="display: none;">
                                    <input type="hidden" name="property-id" value="{{ $room->id }}"
                                        id="property-id">
                                    @csrf
                                </form>
                                <!-- <button class="btn btn-success btn-sm" onclick="location.href='{{ route('room.form') }}'"">Add</button> -->
                                <button class="btn btn-primary btn-sm" onclick="updateproperty()"
                                    value="12">Update</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteproperty()" id='deleteBtn'
                                    value="12">Delete</button>
                            </div>
                        </td> --}}
                @endforeach
                </tr>

                <!-- More rows as needed -->
            </tbody>
        </table>
    </div>


</body>

</html>
