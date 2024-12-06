<ul>
    @php
    $oldData = $record->getOriginal();
    $newData = $record->getAttributes();
    @endphp

    @foreach ($newData as $key => $newValue)
    @php
    $oldValue = $oldData[$key] ?? null;
    @endphp
    @if ($oldValue !== $newValue)
    <li>
        <strong>{{ $key }}</strong>:
        <span style="color:red;">Old: {{ $oldValue }}</span> →
        <span style="color:green;">New: {{ $newValue }}</span>
    </li>
    @endif
    @endforeach
</ul>
