@extends('layouts.admin')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-building"></i> Add Asesor
            </h4>
        </div>
        <form action="{{ route('admin.asesor.store') }}" method="POST">
            @csrf
            @include('Backend.asesor._form')

            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('admin.asesor.index') }}" class="btn btn-secondary me-2">Cancel</a>
            </div>
        </form>
    </div>
@endsection
