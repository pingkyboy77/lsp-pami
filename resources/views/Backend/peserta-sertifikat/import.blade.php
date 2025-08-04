@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h4>Import Participant Certificates</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.peserta-sertifikat.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Excel File (.xlsx)</label>
                <input type="file" name="file" class="form-control" accept=".xlsx" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
@endsection
