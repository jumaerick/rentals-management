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
                    <th>Email</th>
                    <th>Property Name</th>
                    <th>Room Code</th>
                    <th>Total Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    {{-- <th>Actions</th> --}}

                </tr>
            </thead>
            <tbody id="table-body">

                @foreach ($rooms as $room)
                    <tr data-id="{{ $room->id }}">
                        <td> {{ $room->id }}</td>
                        <td> {{ $room->email }}</td>
                        <td>{{ $room->room->property->name }}</td>
                        <td>{{ $room->room->room_code }}</td>
                        <td>{{ $room->amount }}</td>
                        <td>{{ $room->balance }}</td>
                        @if ($room->balance == 0)
                        <td>Cleared</td>
                        @elseif($room->balance > 0)
                        <td>Overpaid</td>
                        @else
                        <td>Pending</td>
                        @endif
                @endforeach
                </tr>

                <!-- More rows as needed -->
            </tbody>
        </table>
    </div>


</body>

</html>
