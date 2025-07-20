{{-- Custom prikaz custom polj pod glavno sliko --}}
@if(!empty($custom_fields) && is_array($custom_fields))
  <div class="mt-4 space-y-2">
    {{-- Prikaz Povezava do spletne strani posebej --}}
    @if(!empty($custom_fields['Povezava do spletne strani']))
      <div>
        <strong>Povezava do spletne strani:</strong>
        <a href="{{ $custom_fields['Povezava do spletne strani'] }}" target="_blank">
          {{ $custom_fields['Povezava do spletne strani'] }}
        </a>
      </div>
    @endif

    {{-- Prikaz ostalih custom fieldov --}}
    @foreach ($custom_fields as $key => $value)
      @if($key !== 'Povezava do spletne strani' && !empty($value))
        <div>
          <strong>{{ $key }}:</strong> {{ $value }}
        </div>
      @endif
    @endforeach
  </div>
@endif
