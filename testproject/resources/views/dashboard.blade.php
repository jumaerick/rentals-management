@extends('layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Dashboard</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card" style="width: 14rem; margin: 0 auto;">
                        <div class="card-body text-center">
                            <p class="card-text">{{ $companies }}</p>
                            <h5 class="card-title mb-0">Companies Listed</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 14rem; margin: 0 auto;">
                        <div class="card-body text-center">
                            <p class="card-text">{{ $properties }}</p>
                            <h5 class="card-title mb-0">Properties Listed</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 14rem; margin: 0 auto;">
                        <div class="card-body text-center">
                            <p class="card-text">{{ $rooms }}</p>
                            <h5 class="card-title mb-0">Rooms Listed</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 14rem; margin: 0 auto;">
                        <div class="card-body text-center">
                            <p class="card-text">{{ $roomsAssigned }}</p>
                            <h5 class="card-title mb-0">Rooms Assigned</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card" style="width: 14rem; margin: 0 auto;">
                        <div class="card-body text-center">
                            <p class="card-text">{{ $roomsAvailable }}</p>
                            <h5 class="card-title mb-0">Rooms Available</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 14rem; margin: 0 auto;">
                        <div class="card-body text-center">
                            <p class="card-text">{{ $users }}</p>
                            <h5 class="card-title mb-0">Register Users</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
