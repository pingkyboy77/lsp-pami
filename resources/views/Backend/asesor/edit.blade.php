@extends('layouts.admin')

@section('content')
    <div class="card mt-4">
<div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-building"></i> Edit Participant Certificate
            </h4>
        </div>
        <form action="{{ route('admin.peserta-sertifikat.update', $asesor->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('Backend.peserta-sertifikat._form')
            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('admin.peserta-sertifikat.index') }}" class="btn btn-secondary me-2">Cancel</a>
            </div>
        </form>
    </div>
@endsection
