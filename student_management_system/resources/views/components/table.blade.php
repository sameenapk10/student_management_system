{{--{{ $setSlot($slot) }}--}}
<table class="table {{ $className }}">
    <tr>
        <th>{{ $title ?? 'Title' }}</th>
    </tr>
    {{ $slot }}
</table>
