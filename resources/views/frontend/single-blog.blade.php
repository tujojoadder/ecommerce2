@extends('layouts.frontend.app')
@section('content')
    <section id="head" class="py-3">
        <div class="head-body container">
            <p class="heading2">{!! $blog->title !!}</p>
            <div class="head-shorts">
                <div class="head-shorts-items">
                    <p class="heading5">
                        <i class="fa-regular fa-calendar"></i> {{ $blog->published_at->format('F d, Y') }}
                    </p>
                    {{--   <p class="heading5">
                        <i class="fa-regular fa-message"></i>1 comment
                    </p> --}}
                </div>
            </div>
            <!-- Image path ঠিক করা হয়েছে -->
            <img height="550px" width="1296px" src="{{ asset('storage/blog/' . $blog->image) }}" class="head-image"
                alt="Blog Header" />

            <p class="head-para paragraph">
                {!! $blog->description !!}
            </p>

        </div>
    </section>
@endsection
