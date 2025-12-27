@extends('layouts.frontend.app')
@section('content')
    <!-- Header Short Banner Start -->
    {{--  <div class="profile-banner blog-banner">
        <h2 class="heading2 text-center">Blog Details</h2>
        <a href="{{ route('frontend.home') }}" class="heading5 text-center d-block">Home / Blog</a>
    </div> --}}


    <!-- Articles Section Start -->
    <section id="article">
        <div class="article-body mb-40 container">
            <div class="row">

                @foreach ($blogs as $blog)
                    <div class="col-md-6">
                        <img width="670px" height="398px" src="{{ asset('storage/blog/' . $blog->image) }}" alt="" />

                        <a href="{{ route('frontend.frontend.blog.show', $blog->id) }}">
                            <h3 class="heading3 mt-20">{!! text_limit($blog->title) !!}</h3>
                        </a>
                        <div class="head-shorts">
                            <div class="head-shorts-items">
                                <p class="heading5">
                                    <i class="fa-regular fa-calendar"></i> {{ $blog->published_at->format('F d, Y') }}
                                </p>
                                {{--  <p class="heading5">
                                    <i class="fa-regular fa-message"></i>1 comment
                                </p> --}}
                            </div>
                        </div>
                        <p class="paragraph">
                            {!! para_limit($blog->description) !!}
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
        <!-- Pagination Start -->
        {{--  <div class="pagination">
            <div class="d-flex align-items-center justify-content-center mx-auto">
                <a href="#">
                    <div class="arrow-left">
                        <i class="fa-solid fa-chevron-left"></i>
                    </div>
                </a>

                <a href="#">
                    <span class="primary">1</span>
                </a>
                <a href="#"><span>2</span></a>
                <a href="#"><span>3</span></a>
                <a href="#"><span>.</span></a>
                <a href="#"><span>.</span></a>
                <a href="#"><span>.</span></a>
                <a href="#"><span>10</span></a>

                <a href="#">
                    <div class="arrow-right">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div> --}}
        <!-- Pagination End -->
    </section>
    <!-- Articles Section End -->

    <div class="square"></div>
@endsection
