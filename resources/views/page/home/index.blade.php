@extends('layouts.app')

@section('content')
    {{-- <div class="py-sm-5"> --}}
        @include('page.home.hero')
        @include('page.home.stats')
        @include('page.home.profile')
        @include('page.home.certification')
        @include('page.home.services')
        @include('page.home.articles')
        @include('page.home.asosiation')
    {{-- </div> --}}
@endsection
