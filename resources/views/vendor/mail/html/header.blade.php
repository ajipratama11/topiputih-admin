<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{'public/img/profile_user/topiputih.png'}}" class="logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
