@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="{{asset('dist/img/AdminLTELogo.png')}}" class="logo" alt="My logo">
@endif
</a>
</td>
</tr>
