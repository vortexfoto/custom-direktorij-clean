@extends('layouts.admin')
@section('title', get_phrase('Form Builder'))
@section('admin_layout')
<script src="{{ asset('assets/backend/js/form-builder/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/form-builder/form-builder.min.js') }}"></script>

<style>
    .form-group{
        position: relative;
        transition: .5s;
    }
    .form-group a{
        height: 26px;
        width: 26px;
        line-height: 24px;
        border: 1px solid #da4949;
        text-align: center;
        border-radius: 5px;
    }
    .form-group .eGap  {
	position: absolute;
	right: 0;
	top: 0;
    visibility: hidden;
    opacity: 0;
    transition: .5s;
}
.form-group a:hover{
    background: #da4949;
    color: #fff !important;
}
.form-group:hover .eGap{
    visibility: visible;
    opacity: 1;
}
.draggable-field {
    cursor: move;
    border: 1px dashed #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    background-color: #fdfdfd;
}
    .notes {
	font-size: 12px;
	color: #010101;
	background: #797c8b30;
	border-radius: 3px;
	padding: 7px 13px;
}
.text-edit{
    line-height: 29px !important;
    border-color: var(--skinColor) !important;
    color: var(--skinColor);
    transition: .5s;
}
.text-edit:hover{
    background: var(--skinColor) !important;
    color: #fff !important;
}
</style>

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
              {{get_phrase('Form Builder')}}
            </h4>

            <a href="{{route('admin.form-builder.create')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span> {{get_phrase('Add New Field')}} </span>
            </a>
        </div>
    </div>
</div>


<div class="row justify-content-center mt-3">
    <div class="col-xl-12">
        <div class="ol-card p-4">
            <div class="ol-card-body">
                @php
                    $types = ['hotel', 'car', 'beauty', 'restaurant', 'real-estate'];
                    @endphp
                    <ul class=" nav nav-tabs eNav-Tabs-custom eTab mb-3" id="typeTabs" role="tablist">
                        @foreach ($types as $index => $type)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                                id="{{ $type }}-tab"  
                                data-bs-toggle="tab"  
                                data-bs-target="#{{ $type }}" 
                                type="button" 
                                role="tab">
                            {{ ucfirst($type) }}
                        </button>
                        
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="typeTabsContent">
                        
                        @foreach ($types as $index => $type)
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="{{ $type }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <form method="POST" action="" class="ol-card category-card radious-10px p-2 h-100">
                                            @csrf
                                            <div id="sortable-fields-{{ $type }}">
                                                @php 
                                                    $form_data = $grouped_forms[$type] ?? []; 
                                                @endphp
                    
                                                @foreach ($form_data as $form)
                                                    @php
                                                        $fields = json_decode($form->form_builder, true);
                                                    @endphp
                                              
                                                    @foreach ($fields as $field)
                                                        <div class="draggable-field" data-name="{{ $field['name'] }}">
                                                            @switch($field['type'])
                                                                @case('text')
                                                                @case('email')
                                                                    <div class="form-group">
                                                                        <label for="{{ $field['name'] }}" class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <input type="{{ $field['subtype'] ?? 'text' }}" name="{{ $field['name'] }}" class="ol-form-control {{ $field['className'] ?? 'form-control ol-form-control' }}" placeholder="{{ $field['placeholder'] ?? '' }}" {{ $field['required'] ? 'required' : '' }}>
                                                                       <div class="d-flex gap-1 eGap">
                                                                       
                                                                          <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                            <span class="fi-rr-trash"></span>
                                                                         </a>
                                                                       </div>
                                                                     
                                                                    </div>
                                                                    @break
                    
                                                                @case('date')
                                                                    <div class="form-group">
                                                                        <label for="{{ $field['name'] }}" class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <input type="date" placeholder="{{ $field['placeholder'] ?? '' }}" name="{{ $field['name'] }}" class="ol-form-control {{ $field['className'] ?? 'form-control ol-form-control' }}" {{ $field['required'] ? 'required' : '' }}>
                                                                        <div class="d-flex gap-1 eGap">
                                                                            
                                                                              <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                                <span class="fi-rr-trash"></span>
                                                                             </a>
                                                                           </div>

                                                                    </div>
                                                                    @break
                    
                                                                @case('number')
                                                                    <div class="form-group">
                                                                        <label for="{{ $field['name'] }}" class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <input type="number" name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" class="ol-form-control {{ $field['className'] ?? 'form-control ol-form-control' }}" {{ $field['required'] ? 'required' : '' }}>
                                                                        <div class="d-flex gap-1 eGap">
                                                                           
                                                                              <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                                <span class="fi-rr-trash"></span>
                                                                             </a>
                                                                           </div>
                                                                     
                                                                    </div>
                                                                    @break
                    
                                                                @case('textarea')
                                                                    <div class="form-group">
                                                                        <label for="{{ $field['name'] }}" class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <textarea name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" class="ol-form-control {{ $field['className'] ?? 'form-control ol-form-control' }}" {{ $field['required'] ? 'required' : '' }}></textarea>
                                                                        <div class="d-flex gap-1 eGap">
                                                                            
                                                                              <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                                <span class="fi-rr-trash"></span>
                                                                             </a>
                                                                           </div>
                                                                     
                                                                    </div>
                                                                    @break
                    
                                                                @case('select')
                                                                    <div class="form-group">
                                                                        <label for="{{ $field['name'] }}" class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <select name="{{ $field['name'] }}" class="ol-select2 {{ $field['className'] ?? 'form-control ol-select2' }}">
                                                                            @foreach ($field['values'] as $option)
                                                                                <option value="{{ $option['value'] }}" {{ $option['selected'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="d-flex gap-1 eGap">
                                                                          
                                                                              <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                                <span class="fi-rr-trash"></span>
                                                                             </a>
                                                                           </div>

                                                                    </div>
                                                                    @break
                    
                                                                @case('checkbox-group')
                                                                    <div class="form-group">
                                                                        <label class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <div class="form-check">
                                                                            @foreach ($field['values'] as $option)
                                                                                <input type="checkbox" name="{{ $field['name'] }}[]" value="{{ $option['value'] }}" class="form-check-input" {{ $option['selected'] ? 'checked' : '' }}>
                                                                                <label class="form-check-label">{{ $option['label'] }}</label><br>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="d-flex gap-1 eGap">
                                                                            
                                                                              <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                                <span class="fi-rr-trash"></span>
                                                                             </a>
                                                                           </div>
                                                                     
                                                                    </div>
                                                                    @break
                    
                                                                @case('radio-group')
                                                                    <div class="form-group">
                                                                        <label class="ol-form-label">{{ $field['label'] }}</label>
                                                                        <div class="form-check">
                                                                            @foreach ($field['values'] as $option)
                                                                                <input type="radio" name="{{ $field['name'] }}" value="{{ $option['value'] }}" class="form-check-input" {{ $option['selected'] ? 'checked' : '' }}>
                                                                                <label class="form-check-label">{{ $option['label'] }}</label><br>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="d-flex gap-1 eGap">
                                                                              <a href="javascript:void(0);"   class="fs-14px text-danger"   onclick="delete_modal('{{ route('form-builder.delete', ['type' => $type, 'name' => urlencode($field['name'])]) }}')">
                                                                                <span class="fi-rr-trash"></span>
                                                                             </a>
                                                                           </div>
                                                                     
                                                                    </div>
                                                                    @break
                                                            @endswitch
                                                        </div>
                                                    @endforeach
                                                  
                                                @endforeach
                                            </div>
                    
                                            @if (count($form_data))
                                            <p class="notes">
                                                {{ get_phrase('You can reorder the fields by dragging and dropping each item. The order you set here will be reflected on the frontend.') }}
                                            </p>
                                        
                                            <div class="d-flex gap-3">

                                                <button type="button" class="btn ol-btn-primary mt-3" id="save-order-{{ $type }}"> {{ get_phrase('Save Field Order') }}</button>
                                                <a href="{{route('form-builder.edit',['type' => $type] )}}" class="btn ol-btn-primary mt-3">{{get_phrase('Edit')}}</a>
                                            </div>
                                            @else
                                            @include('layouts.no_data_found')
                                          @endif
                                        
                                        </form>
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                            </div>
                        @endforeach
                       
                    </div> 
            </div> <!-- end card-body-->
        </div>
    </div>
</div>




    <script>
        $(document).ready(function () {
            let types = ['hotel', 'car', 'beauty', 'restaurant', 'real-estate'];
            types.forEach(function(type) {
                $('#sortable-fields-' + type).sortable({
                    placeholder: "ui-state-highlight"
                });
    
                $('#save-order-' + type).click(function () {
                    var order = [];
    
                    $('#sortable-fields-' + type + ' .draggable-field').each(function () {
                        order.push($(this).data('name'));
                    });
    
                    $.ajax({
                        url: '{{ route("form-builder.reorder") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            type: type, // if you want to track type on backend
                            order: order
                        },
                        success: function (response) {
                            success('Field order saved for ' + type + ' successfully!');
                        }
                    });
                });
            });
        });
    </script>
    
    <script>
        document.querySelectorAll('#typeTabs .nav-link').forEach(button => {
            button.addEventListener('click', function () {
                localStorage.setItem('activeTab', this.getAttribute('data-bs-target'));
            });
        });
        document.querySelectorAll('a.text-danger').forEach(link => {
            link.addEventListener('click', function () {
                const activeTab = document.querySelector('.nav-link.active')?.getAttribute('data-bs-target');
                if (activeTab) {
                    localStorage.setItem('activeTab', activeTab);
                }
            });
        });
    

        document.addEventListener('DOMContentLoaded', function () {
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                const triggerEl = document.querySelector(`button[data-bs-target="${activeTab}"]`);
                if (triggerEl) {
                    new bootstrap.Tab(triggerEl).show();
                }
            }
        });
    </script>
    



@endsection

