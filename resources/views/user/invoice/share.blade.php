@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@push('head')
    <head>
        <meta property="og:title" content="Invoice #{{ $invoice->id }}" />
        <meta property="og:description" content="Client: {{ $invoice->client_name }} - Amount: {{ $invoice->total_amount }}" />
        <meta property="og:image" content="{{ asset('dashboard/img/brand/logo.png') }}" />
        <meta property="og:url" content="{{ route('user.invoice.show', ['id' => $invoice->id]) }}" />
        <meta property="og:type" content="website" />
    </head>
@endpush
@section('content')
    <style>
        div#social-links {
            margin: 0 auto;
            max-width: 500px;
        }

        div#social-links ul li {
            display: inline-block;
        }

        div#social-links ul li a {
            padding: 20px;
            border: 1px solid #ccc;
            margin: 1px;
            font-size: 30px;
            color: #222;
            background-color: #ccc;
        }

        .social-button {
            border-radius: 10% !important;
        }
    </style>
    <div class="card my-5 py-5">
        <div class="card-header">
            <h4 class="card-title text-center">Share on Social Media</h4>
        </div>
        <div class="card-body gap-3">
            {!! $shareComponent !!}
        </div>
    </div>
@endsection
