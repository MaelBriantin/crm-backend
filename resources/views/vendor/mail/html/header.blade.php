@props(['url'])
<tr>
<td class="header">
<a href="{{ env('FRONTEND_URL') }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
    <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
    <img src="{{ asset('storage/images/butterfly.svg') }}" alt="LotusCRM Logo">
@endif
</a>
</td>
</tr>
