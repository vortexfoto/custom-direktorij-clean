@extends('layouts.admin')
@section('title', get_phrase('Form Builder'))
@section('admin_layout')
<script src="{{ asset('assets/backend/js/form-builder/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/form-builder/form-builder.min.js') }}"></script>
<style>
   
.form-wrap.form-builder .frmb .prev-holder input[type="number"],
.form-wrap.form-builder .frmb .prev-holder input[type="date"] {
	width: 100%;
}
.form-wrap.form-builder .frmb .prev-holder select, .form-wrap.form-builder .frmb .prev-holder input[type="text"], .form-wrap.form-builder .frmb .prev-holder textarea, .form-wrap.form-builder .frmb .prev-holder input[type="number"] {
	padding: 10px 15px !important;
}
.form-wrap.form-builder.formbuilder-embedded-bootstrap .form-control {
	height: auto;
	line-height: 18px;
	padding: 10px 15px !important;
}
.form-wrap.form-builder .frmb li.form-field:hover {
	box-shadow: none;
    background: #dfedff;
}
.field-label {
	font-weight: 500 !important;
	font-size: 14px !important;
	color: var(--darkColor) !important;
}
 .form-control {
	border: 1px solid var(--borderColor) !important;
	border-radius: 8px !important;
	padding: 10px 15px !important;
	font-weight: 400;
	font-size: 14px !important;
	line-height: 20px !important;
	color: var(--grayColor);
	transition: .3s;
}
.formbuilder-text .form-control:hover, .formbuilder-text .form-control:focus {
	color: var(--grayColor);
	border-color: var(--skinColor);
	box-shadow: none;
}
.form-wrap.form-builder .frmb .prev-holder select, .form-wrap.form-builder .frmb .prev-holder input[type="text"], .form-wrap.form-builder .frmb .prev-holder textarea, .form-wrap.form-builder .frmb .prev-holder input[type="number"] {
	box-shadow: none;
}
.form-wrap.form-builder .frmb li.form-field {
	padding: 10px;
    border-radius: 5px;
}
.form-wrap.form-builder .frmb .field-actions {
	top: 6px;
	right: 7px;
    gap: 4px;
    display: flex;
}
.form-wrap.form-builder .frmb .field-actions .btn {
	border-radius: 5px !important;
	border-width: 0;
}
.form-wrap.form-builder .frmb .field-actions .btn:first-child {
	border-radius: 5px;
}

.form-wrap.form-builder .frmb .field-actions a:hover,
.form-wrap.form-builder .frmb .field-actions .copy-button:hover,
.form-wrap.form-builder .frmb .field-actions .toggle-form:hover,
.form-wrap.form-builder .frmb .field-actions .del-button:hover {
	background-color: #1b84ff;
    color: #fff;
}
.form-wrap.form-builder .frmb-control li:hover {
	background: #dfedff;
}
.form-wrap.form-builder .frmb-control li {
	box-shadow: none;
	border: 1px solid #9eb5d4;
}
.form-wrap.form-builder .frmb-control li span{
    color: #000;
}

.form-wrap.form-builder .stage-wrap.empty {
	border: 3px dashed #9eb5d4;
	background-color: rgba(255,255,255,.25);
}
.form-wrap.form-builder .stage-wrap.empty::after {
	color: #000000c4;
	font-weight: 500;
}
</style>
<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px capitalize" >
                <i class="fi-rr-settings-sliders me-2"></i>
              {{get_phrase('Update')}} {{$form_data->type}} {{'Form'}}
            </h4>
            <a href="{{route('admin.form-builder')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-arrow-left"></span>
                <span class="capitalize"> {{get_phrase('Back')}} </span>
            </a>
        </div>
    </div>
</div>
<form method="POST" action="{{ route('form-builder.update', ['type' => $form_data->type]) }}" id="form-builder-form">
    @csrf
    <div class="ol-card mt-3">
        <div class="ol-card-body p-3">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div id="fb-editor"></div>
                    <textarea id="formData" name="form_builder" hidden></textarea>
                    <button type="submit" id="saveBtn" class="btn btn-primary mt-3 d-none">{{ get_phrase('Update') }}</button>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
    </div>
</form>

<script>
    jQuery(function($) {
        const fbEditor = document.getElementById('fb-editor');
        const saveBtn = $('#saveBtn');
        const formBuilder = $(fbEditor).formBuilder({
            disableFields: ['file', 'autocomplete', 'header', 'hidden', 'paragraph', 'button'],
            showActionButtons: false,
            controlOrder: ['text', 'textarea', 'date', 'select', 'number', 'radio-group', 'checkbox-group'],
            onAddField: toggleSaveBtn,
            onCloseFieldEdit: toggleSaveBtn,
            onSave: toggleSaveBtn,
            onFieldRemoved: toggleSaveBtn
        });

        formBuilder.promise.then(fb => {
            const existingData = {!! json_encode($form_data->form_builder) !!};
            fb.actions.setData(existingData); 
            if (existingData.length > 0) {
                saveBtn.removeClass('d-none');
            }
        });

        function toggleSaveBtn() {
            const data = formBuilder.actions.getData('json');
            const parsed = JSON.parse(data);

            if (parsed.length > 0) {
                saveBtn.removeClass('d-none');
            } else {
                saveBtn.addClass('d-none');
            }
        }

        $('#form-builder-form').on('submit', function(e) {
            const formData = formBuilder.actions.getData('json');
            const parsedData = JSON.parse(formData);
            if (parsedData.length === 0) {
                e.preventDefault(); 
                alert('Please add at least one field to the form.');
                return false;
            }

            $('#formData').val(formData);

        });
    });
</script>






@endsection