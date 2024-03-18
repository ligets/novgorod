@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<!-- {{ $slot }} -->
<img src="https://cdn-icons-png.flaticon.com/512/5989/5989237.png" class="logo" alt="{{ $slot }}">
@endif
</a>
</td>
</tr>
