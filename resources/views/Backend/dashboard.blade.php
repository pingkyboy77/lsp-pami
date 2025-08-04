@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Dashboard Admin</h2>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">Total User</h5>
                    <h3 class="card-text">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection