@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- <h2 class="fw-bold mb-4 text-primary-emphasis">{{ $title ?? '' }}</h2> --}}
    <h2 class="modern-title">{{ $title ?? 'Frequently Asked Questions (FAQ)' }}</h2>
        <hr class="modern-hr">

    <div class="accordion accordion-flush" id="faqAccordion">
        @forelse ($faqs as $index => $faq)
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                        {{ $faq->question }}
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        {!! $faq->answer !!}
                    </div>
                </div>
            </div>
        @empty
                <div class="row">
                    <div class="alert alert-warning d-flex justify-content-center col-12">Belum Faq.</div>
                </div>
            @endforelse
    </div>
</div>
@endsection
