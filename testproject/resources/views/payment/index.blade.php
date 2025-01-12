@extends('layouts.app')
@section('content')
@if (Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All Payments</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('payment.form') }}">Add Payment</a>
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
                        <th>Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>

                        @forelse ($payments as $payment)
                        <td> {{ $payment->id }}</td>
                        <td> {{ $payment->rent->room->property->name ?? '' }}</td>
                        <td>{{ $payment->rent->room->room_code}}</td>
                        <td>{{ $payment->amount}}</td>
                        <td>{{ $payment->created_at}}</td>

                        <td class="edit">
                            <a href="{{route('payment.edit', $payment->id)}}" class="btn btn-success">Edit</a>
                        </td>
                        <td class="delete">
                            <button data-pid='{{$payment->id}}' class="btn btn-danger delete-payment">Delete</button>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No rooms Listed</td>
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
        var user_id = $(this).data("uid");
        var token = $('meta[name="csrf-token"]').attr('content');
        var ViewRoute = "{{route('user.show', ':id')}}"
        ViewRoute = ViewRoute.replace(':id', user_id);
        $.ajax({
            url: ViewRoute,
            data: {
                _token: token
            },
            type: "post",
            success: function(user) {
                console.log(user);
                form = "<tr><td>Username :</td><td><b>" + user['name'] + "</b></td></tr><tr><td>Email :</td><td><b>" + user['email'] + "</b></td></tr><tr><td>Location :</td><td><b>" + user['location'] + "</b></td></tr><tr><td>Phone :</td><td><b>" + user['phone_number'] + "</b></td></tr>";
                console.log(form);

                $("#modal-form table").html(form);
                $("#modal").show();
            }
        });
    });

    $('#close-btn').on("click", function() {
        $("#modal").hide();
    });

    $(".delete-payment").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {

            var p_id = $(this).data("pid");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('payment.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', p_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: p_id,
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