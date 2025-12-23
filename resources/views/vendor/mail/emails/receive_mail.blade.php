@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('company.name') }} - {{ __('messages.money_receipt') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $messageBody }}

Regards,
{{ config('company.name') }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
@endcomponent
@endslot
@endcomponent
