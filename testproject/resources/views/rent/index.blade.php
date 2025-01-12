@extends('layouts.app')
@section('content')
@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All Rents</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('rent.form') }}">Add Rent</a>
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
                    <th>Deposit</th>
                    <th>Rent Amount</th>
                    <th>Rent Date</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>

                        @forelse ($rents as $rent)
                        <td> {{ $rent->id }}</td>
                        <td>{{ $rent->room->property->name }}</td>
                        <td>{{ $rent->room->room_code }}</td>
                        <td>{{ $rent->deposit ?? '' }}</td>
                        <td>{{ $rent->amount ?? ''}}</td>
                        <td>{{ $rent->rent_date ?? ''}}</td>

                        <td class="view">
                            <button data-rid='{{ $rent->id }}>'
                                class="btn btn-primary view-btn" id='btnMe'>View</button>
                        </td>
                        <td class="edit">
                            <a href="{{route('rent.edit', $rent->id)}}" class="btn btn-success">Edit</a>
                        </td>
                        <td class="delete">
                            <button data-rid='{{$rent->id}}' class="btn btn-danger delete-rent">Delete</button>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No rents Listed</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>


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
        var rent_id = $(this).data("rid");
        var token = $('meta[name="csrf-token"]').attr('content');
        var ViewRoute = "{{route('rent.show', ':id')}}"
        ViewRoute = ViewRoute.replace(':id', rent_id);
        $.ajax({
            url: ViewRoute,
            data: {
                _token: token
            },
            type: "post",
            success: function(rent) {
                console.log(rent);
                form = "<tr><td>Room Code :</td><td><b>" + rent['room']['room_code'] + "</b></td></tr><tr><td>Amount :</td><td><b>" + rent['amount'] + "</b></td></tr><tr><td>Deposit :</td><td><b>" + rent['deposit'] + "</b></td></tr><tr><td>Rent Data :</td><td><b>" + rent['rent_date'] + "</b></td></tr>";
                console.log(form);

                $("#modal-form table").html(form);
                $("#modal").show();
            }
        });
    });

    $('#close-btn').on("click", function() {
        $("#modal").hide();
    });

    $(".delete-rent").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {

            var r_id = $(this).data("rid");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('rent.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', r_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: r_id,
                    _token:token
                },
                success: function(response) {

                    if (response.status == true) {
                        alert('deleted successfully');
                        setTimeout(
                            location.reload(), 1000
                        )

                    } else {
                        alert('Something went wrong');
                        setTimeout(
                            location.reload(), 1000
                        )
                    }
                    }
            });
        }

        });

</script>

@endsection