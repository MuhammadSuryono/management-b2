@component('mail::layout')
{{-- Header --}}
{{-- @slot('header')
@component('mail::header', ['url' => config('app.url')])
MRI B2
@endcomponent
@endslot --}}

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
{{-- @slot('footer')
@component('mail::footer')
© {{ date('Y') }} Marketing Research Indonesia. @lang('All rights reserved.')
@endcomponent
@endslot --}}
@endcomponent
