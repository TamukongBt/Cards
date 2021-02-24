

@component('mail::message')
Dear Customer,  {{-- use double space for line break --}}
You chequebook is available at UBC  *{{$branch}}* Branch,

Visit us to collect your chequebook as soon as possible
Thanks for trusting in our services,<br>

Sincerely,
Union Bank Cameroon.
@endcomponent
