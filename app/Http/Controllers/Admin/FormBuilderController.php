<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FormBuilder;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;



class FormBuilderController extends Controller
{


public function form_builder(Request $request)
    {
        $form_data = FormBuilder::where('user_id', auth()->user()->id)->get();
        $grouped_forms = [];

        foreach ($form_data as $form) {
            $grouped_forms[$form->type][] = $form;
        }

        return view("admin.form-builder.index", [
            'grouped_forms' => $grouped_forms,
            'active_tab' => $request->get('tab') // get active tab from query string
        ]);
    }


public function store(Request $request)
{
    $request->validate([
        'type' => 'required',
        'form_builder' => 'required|json',
    ]);

    $newData = json_decode($request->form_builder, true); 
    $existing = FormBuilder::where('user_id', auth()->user()->id)->where('type', $request->type)->first();

    if ($existing) {
        $existingData = json_decode($existing->form_builder, true); 
        $mergedData = array_merge($existingData, $newData); 
        $existing->update([
            'form_builder' => json_encode($mergedData), 
            'updated_at' => Carbon::now(),
        ]);
    } else {
        FormBuilder::create([
            'form_builder' => $request->form_builder,
            'user_id' => auth()->user()->id,
            'type' => $request->type,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    return redirect()->route('admin.form-builder', ['tab' => $request->type])
    ->with('success', get_phrase('Field saved successfully!'));

}


public function saveOrder(Request $request)
{
    $request->validate([
        'order' => 'required|array',
        'type' => 'required|string', 
    ]);

    $type = $request->input('type');
    
    $formBuilder = FormBuilder::where('type', $type)->first();
    if (!$formBuilder) {
        return response()->json(['status' => 'error', 'message' => 'Form Builder not found for this type.']);
    }
    $currentFormFields = json_decode($formBuilder->form_builder, true);
    $sortedFields = [];
    foreach ($request->input('order') as $fieldName) {
        foreach ($currentFormFields as $field) {
            if ($field['name'] === $fieldName) {
                $sortedFields[] = $field;
                break;
            }
        }
    }
    $formBuilder->form_builder = json_encode($sortedFields);
    $formBuilder->save();

    return response()->json(['status' => 'success', 'message' => 'Field order saved successfully for ' . ucfirst($type)]);
}




public function delete($type, $name)
{
    $form = FormBuilder::where('type', $type)->first();

    if (!$form) {
        return back()->with('error', 'Form not found for the given type.');
    }
    $fields = json_decode($form->form_builder, true);
    if (!is_array($fields)) {
        return back()->with('error', 'Invalid form data.');
    }
    $normalizedName = strtolower(trim($name));
    $filteredFields = array_filter($fields, function ($field) use ($normalizedName) {
        return isset($field['name']) && strtolower(trim($field['name'])) !== $normalizedName;
    });
    if (count($filteredFields) === count($fields)) {
        return back()->with('error', 'Field not found.');
    }
    $form->form_builder = json_encode(array_values($filteredFields), JSON_UNESCAPED_UNICODE);
    $form->save();

    // return back()->with('success', 'Field deleted successfully.');
    return redirect()->route('admin.form-builder', ['tab' => $form->type])
    ->with('success', get_phrase('Field deleted successfully!'));

}




    public function formBuilderCreate(){
        return view("admin.form-builder.create");
    }
    


    // Frontend Form Submit
    public function builderAppointment(Request $request)
    {
        if (!Auth::check()) {
            Session::flash('warning', get_phrase('Please Login First!'));
            return redirect()->back();
        }
    
        if (auth()->id() == $request->agents_id) {
            Session::flash('warning', get_phrase("You can't book your own business!"));
            return redirect()->back();
        }
    
        // Collect dynamic form data
        $formBuilderData = [];
        $exclude = ['_token', 'types', 'listings_id', 'agents_id'];
    
        foreach ($request->except($exclude) as $key => $value) {
            if (empty($value)) {
                Session::flash('warning', get_phrase('All fields are required!'));
                return redirect()->back();
            }
    
            $formBuilderData[$key] = is_array($value) ? implode(', ', $value) : $value;
        }
    
        $appointment = new Appointment();
        $appointment->date = now();
        $appointment->customer_id = auth()->user()->id;
        $appointment->listing_id = $request->listings_id;
        $appointment->agent_id = $request->agents_id;
        $appointment->type = 'person';
        $appointment->status = 0;
        $appointment->form_builder = json_encode($formBuilderData);

        $appointment->name = $request->input('name', auth()->user()->name ?? 'Guest');
        $appointment->email = $request->input('email', auth()->user()->email ?? null);
        $appointment->phone = $request->input('phone', '01987979900');
        $appointment->message = $request->input('message', 'Form Builder');
        $appointment->time =  now()->format('H:i');
        $appointment->listing_type = $request->types;

        $appointment->save();
    
        Session::flash('success', get_phrase('Appointment placed successfully!'));
        return redirect()->back();
    }



    public function edit($type){
        $page_data['form_data'] =  FormBuilder::where('type', $type)->first();
        return view("admin.form-builder.edit", $page_data);
    }


    public function update(Request $request, $type)
{
    $request->validate([
        'form_builder' => 'required|json',
    ]);

    $form = FormBuilder::where('type', $type)->first();

    if (!$form) {
        return back()->with('error', 'Form not found.');
    }

    $form->form_builder = $request->form_builder;
    $form->save();

    // Redirect with tab preserved
    return redirect()->route('admin.form-builder', ['tab' => $request->get('tab')])
                     ->with('success', 'Form updated successfully!');
}

    





















}
