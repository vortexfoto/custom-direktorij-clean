@php 
       $form = App\Models\FormBuilder::where('type', $type)->first();
       $form_data = $form ? json_decode($form->form_builder, true) : [];
@endphp 
<style>
    .draggable-field .smform-label2 {
        font-weight: 600;
        font-size: 14px;
        margin: 5px 0;
    }
</style>
<form method="POST" action="{{route('builderAppointment')}}" >
    @csrf
    <input type="hidden" name="types" value="{{$type}}">
    <input type="hidden" name="listings_id" value="{{ $listing->id }}">
    <input type="hidden" name="agents_id" value="{{ $listing->user_id }}">
    <div id="sortable-fields">
        @foreach ($form_data as $field)
            <div class="draggable-field" data-name="{{ $field['name'] }}">
                @switch($field['type'])
                    @case('text')
                    @case('email')
                        <div class="form-group">
                            <label for="{{ $field['name'] }}" class="smform-label2">{{ $field['label'] }}</label>
                            <input type="{{ $field['subtype'] ?? 'text' }}"  name="{{ $field['name'] }}" class="mform-control {{ $field['className'] ?? 'form-control mform-control' }}"   placeholder="{{ $field['placeholder'] ?? '' }}"  {{ $field['required'] ? 'required' : '' }}>
                           
                        </div>
                        @break
                    @case('date')
                        <div class="form-group">
                            <label for="{{ $field['name'] }}" class="smform-label2">{{ $field['label'] }}</label>
                            <input type="date"  name="{{ $field['name'] }}"  class="form-control mform-control flat-input-picker4 input-calendar-icon  {{ $field['className'] ?? 'form-control mform-control' }}" {{ $field['required'] ? 'required' : '' }} placeholder="{{ $field['placeholder'] ?? '' }}">
                            
                        </div>
                        @break
                    @case('number')
                        <div class="form-group">
                            <label for="{{ $field['name'] }}" class="smform-label2">{{ $field['label'] }}</label>
                            <input type="number"  name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}"  class="form-control mform-control {{ $field['className'] ?? 'form-control mform-control' }}" {{ $field['required'] ? 'required' : '' }}>
                           
                        </div>
                        @break
                    @case('textarea')
                        <div class="form-group">
                            <label for="{{ $field['name'] }}" class="smform-label2">{{ $field['label'] }}</label>
                            <textarea name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" class="mform-control {{ $field['className'] ?? 'form-control mform-control' }}"  {{ $field['required'] ? 'required' : '' }}></textarea>
                           
                        </div>
                        @break
                    @case('select')
                        <div class="form-group">
                            <label for="{{ $field['name'] }}" class="smform-label2">{{ $field['label'] }}</label>
                            <select name="{{ $field['name'] }}" class="nice-select mNiceSelect review-select mform-control {{ $field['className'] ?? 'form-control ol-select2' }}">
                                @foreach ($field['values'] as $option)
                                    <option value="{{ $option['value'] }}"  {{ $option['selected'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                        @break
                    @case('checkbox-group')
                        <div class="form-group">
                            <label class="smform-label2">{{ $field['label'] }}</label>
                            <div class="form-check">
                                @foreach ($field['values'] as $option)
                                    <input type="checkbox"  name="{{ $field['name'] }}[]" value="{{ $option['value'] }}" 
                                        class="form-check-input"  {{ $option['selected'] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $option['label'] }}</label><br>
                                @endforeach
                            </div>
                           
                        </div>
                        @break
                    @case('radio-group')
                        <div class="form-group">
                            <label class="smform-label2">{{ $field['label'] }}</label>
                            <div class="form-check">
                                @foreach ($field['values'] as $option)
                                    <input type="radio"   name="{{ $field['name'] }}" value="{{ $option['value'] }}" 
                                        class="form-check-input"  {{ $option['selected'] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $option['label'] }}</label><br>
                                @endforeach
                            </div>
                        </div>
                        @break
                @endswitch
            </div>
        @endforeach
        @if(count($form_data) > 0)
        <button type="submit" class="submit-fluid-btn2 mt-3 mb-2">{{ get_phrase('Submit Now') }}</button>
        @endif
    </div>
   
</form>


<script>
    "use strict";
    $(document).ready(function() {
        flatpickr(".flat-input-picker4", {
            enableTime: true,
            dateFormat: "Y-m-d H:i:S",
            minDate: "today",
        });
    });
</script>
