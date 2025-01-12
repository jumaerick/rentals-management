@extends('layouts.app')
@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All Rooms</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('room.form') }}">Add Room</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                    <th>#</th>
                    <th>Property Name</th>
                    <th>Room Code</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                        <tr>
                        <td> {{ $room->id }}</td>
                        <td>{{ $room->property->name }}</td>
                        <td>{{ $room->room_code }}</td>
                        <td class="view">
                <button data-rid='{{ $room->id }}>'
                    class="btn btn-primary view-btn" id='btnMe'>View</button>
            </td>
                            <td class="edit">
                                <a href="{{route('room.edit', $room->id)}}" class="btn btn-success">Edit</a>
                            </td>
                            <td class="delete">
                                <button data-rid='{{$room->id}}' class="btn btn-danger delete-room">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No Rooms Listed</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $rooms->links('vendor/pagination/bootstrap-4') }}
                <div id="modal">
                    <div id="modal-form">
                        <table cellpadding="10px" width="100%">

                        </table>
                        <div id="close-btn">X</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript">
    // $('#btnMe').on('click', function() {
    //     alert('yes');
    // })

    $(".view-btn").on("click", function() {
        var room_id = $(this).data("rid");
        var token = $('meta[name="csrf-token"]').attr('content');
        var ViewRoute = "{{route('room.show', ':id')}}"
        ViewRoute = ViewRoute.replace(':id', room_id);
        $.ajax({
            url: ViewRoute,
            data: {
                _token: token
            },
            type: "post",
            success: function(room) {
                form = "<tr><td>Property :</td><td><b>" + room['name'] + "</b></td></tr><tr><td>Room Code :</td><td><b>" + room['room_code'] + "</b></td></tr>";
                console.log(form);

                $("#modal-form table").html(form);
                $("#modal").show();
            }
        });
    });

    $('#close-btn').on("click", function() {
        $("#modal").hide();
    });

    $(".delete-room").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {
            var u_id = $(this).data("rid");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('room.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', u_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: u_id,
                    _token: token
                },
                success: function(data) {
                    $(".message").html(data);
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }
            });
        }

    });
</script>


@endsection