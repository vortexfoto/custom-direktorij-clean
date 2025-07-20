<?php

namespace App\Http\Controllers\Agent;
use App\Http\Controllers\Controller; 
use App\Models\CustomField;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class AgentCustomFieldController extends Controller
{
    public function customField_Create ($type,  $listing_id=""){
         $page_data['type'] = $type;    
         $page_data['listing_id'] = $listing_id;    
         return view('user.agent.custom-field.create', $page_data);
      }  



public function customField_store(Request $request)
{
    $requestData = $request->all();
    $custom_type = $request->custom_type;
    $data = [];

    // Detect the correct custom_title field based on custom_type
    $custom_title_key = $custom_type . '_custom_title'; 
    $custom_title = $request->input($custom_title_key); 

    if ($custom_type == 'image') {
        $images = [];
        $i = 1;
        if ($request->hasFile('image_file')) {
            foreach ($request->file('image_file') as $index => $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/custom-fields'), $filename);
                $images[] = [
                    'id' => $i++,
                    'title' => $request->image_title[$index],
                    'description' => $request->image_description[$index],
                    'file' => $filename
                ];
            }
        }
        $data = ['data' => $images];
    } elseif ($custom_type == 'text') {
        $texts = [];
        $i = 1;
        foreach ($request->text_content as $text) {
            $texts[] = [
                'id' => $i++,
                'content' => $text
            ];
        }
        $data = ['data' => $texts];
    } elseif ($custom_type == 'slider') {
        $slides = [];
        $i = 1;
        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $index => $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/custom-fields'), $filename);
                $slides[] = [
                    'id' => $i++,
                    'file' => $filename,
                    'title' => $request->slider_title[$index] ?? '',
                    'description' => $request->slider_description[$index] ?? '',
                ];
            }
        }
        $data = ['data' => $slides];
    } elseif ($custom_type == 'gallery') {
        $gallery = [];
        $i = 1;
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/custom-fields'), $filename);
                $gallery[] = [
                    'id' => $i++,
                    'file' => $filename,
                ];
            }
        }
        $data = ['data' => $gallery];
    } elseif ($custom_type == 'video') {
        $videos = [];
        $i = 1;
        foreach ($request->video_url as $url) {
            $videos[] = [
                'id' => $i++,
                'url' => $url
            ];
        }
        $data = ['data' => $videos];
    } elseif ($custom_type == 'faq') {
        $faqs = [];
        $i = 1;
        foreach ($request->faq_question as $index => $q) {
            $faqs[] = [
                'id' => $i++,
                'question' => $q,
                'answer' => $request->faq_answer[$index]
            ];
        }
        $data = ['data' => $faqs];
    }

    $customfield = CustomField::where('listing_type', $request->input('type'))
        ->where('listing_id', $request->input('listing_id'))
        ->where('custom_type', $custom_type)
        ->first();

    if ($customfield) {
        $existingData = json_decode($customfield->custom_field, true);

        if ($custom_type == 'video') {
            $existingData['data'] = $data['data'];
        } else {
            if (isset($existingData['data']) && is_array($existingData['data'])) {
                $lastId = collect($existingData['data'])->max('id') ?? 0;
                $newData = $data['data'];
                foreach ($newData as &$item) {
                    $item['id'] = ++$lastId;
                }
                $existingData['data'] = array_merge($existingData['data'], $newData);
            } else {
                $existingData = $data;
            }
        }

        $customfield->custom_field = json_encode($existingData);
        $customfield->custom_title = $custom_title;
    } else {
        $customfield = new CustomField();
        $customfield->listing_type = $request->input('type');
        $customfield->listing_id = $request->input('listing_id');
        $customfield->custom_type = $custom_type;
        $customfield->custom_title = $custom_title;
        $customfield->custom_field = json_encode($data);
    }

    $customfield->save();

    Session::flash('success', get_phrase('Data Added successfully!'));
    return redirect()->back();
}



public function customFieldDelete($field_id, $item_id)
{
    $customField = CustomField::findOrFail($field_id);
    $fieldData = json_decode($customField->custom_field, true);
    if (!is_array($fieldData) || !isset($fieldData['data'])) {
        Session::flash('error', 'Invalid custom field format.');
        return redirect()->back();
    }
    $updatedItems = [];
    foreach ($fieldData['data'] as $item) {
        if ($item['id'] == $item_id) {
            if (!empty($item['file'])) {
                $imagePath = public_path('uploads/custom-fields/' . $item['file']);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }
        } else {
            $updatedItems[] = $item;
        }
    }
    $fieldData['data'] = $updatedItems;
    $customField->custom_field = json_encode($fieldData);
    $customField->save();

    Session::flash('success', 'Custom field item deleted successfully.');
    return redirect()->back();
}

public function customFieldEdit($field_id, $item_id)
{
    $customField = CustomField::findOrFail($field_id);
    $data = json_decode($customField->custom_field, true);

    if (!is_array($data) || !isset($data['data'])) {
        return response()->json(['error' => 'Invalid data']);
    }

    $page_data['item'] = collect($data['data'])->firstWhere('id', $item_id);
    $page_data['customField'] = $customField;

    return view('user.agent.custom-field.edit',$page_data );
}

public function customFieldUpdate(Request $request, $field_id, $item_id)
{
    $customField = CustomField::findOrFail($field_id);
    $fieldData = json_decode($customField->custom_field, true);

    $updatedData = [];

    foreach ($fieldData['data'] as $item) {
        if ($item['id'] == $item_id) {
            $type = $customField->custom_type;

            if ($type == 'image') {
                $newTitle = $request->input('image_title')[0];
                $newDescription = $request->input('image_description')[0];
                $newFile = $request->file('image_file')[0] ?? null;

                if ($newFile) {
                    if (!empty($item['file'])) {
                        $oldPath = public_path('uploads/custom-fields/' . $item['file']);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    $filename = time() . '_' . $newFile->getClientOriginalName();
                    $newFile->move(public_path('uploads/custom-fields'), $filename);
                    $item['file'] = $filename;
                }
                $item['title'] = $newTitle;
                $item['description'] = $newDescription;

            } elseif ($type == 'text') {
                $newDescription = $request->input('text_content')[0];
                $item['content'] = $newDescription;

            } elseif ($type == 'slider') {
                $newTitle = $request->input('slider_title')[0];
                $newDescription = $request->input('slider_description')[0];
                $newFile = $request->file('slider_images')[0] ?? null;

                if ($newFile) {
                    if (!empty($item['file'])) {
                        $oldPath = public_path('uploads/custom-fields/' . $item['file']);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    $filename = time() . '_' . $newFile->getClientOriginalName();
                    $newFile->move(public_path('uploads/custom-fields'), $filename);
                    $item['file'] = $filename;
                }
                $item['title'] = $newTitle;
                $item['description'] = $newDescription;

            } elseif ($type == 'video') {
                $newUrl = $request->input('video_url')[0];
                $item['url'] = $newUrl;

            } elseif ($type == 'faq') {
                $newTitle = $request->input('faq_question')[0];
                $newDescription = $request->input('faq_answer')[0];
                $item['question'] = $newTitle;
                $item['answer'] = $newDescription;

            } elseif ($type == 'gallery') {
                $newFiles = $request->file('gallery_images');
                if ($newFiles && isset($newFiles[0])) {
                    if (!empty($item['file'])) {
                        $oldPath = public_path('uploads/custom-fields/' . $item['file']);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    $filename = time() . '_' . $newFiles[0]->getClientOriginalName();
                    $newFiles[0]->move(public_path('uploads/custom-fields'), $filename);
                    $item['file'] = $filename;
                }
            }
        }

        $updatedData[] = $item;
    }

    $fieldData['data'] = $updatedData;
    $customField->custom_field = json_encode($fieldData);
    $customField->save();

    Session::flash('success', 'Custom field updated successfully.');
    return redirect()->back();
}


public function customSectionEdit($id)
{
    $page_data['customField'] = CustomField::findOrFail($id);
    return view('user.agent.custom-field.section_edit', $page_data);
}

public function customSectionUpdate(Request $request, $id)
{
    $customField = CustomField::findOrFail($id);
    $customField->custom_title = $request->input('custom_title');
    $customField->save();
    Session::flash('success', 'Custom section updated successfully!');
    return redirect()->back();
}



public function customSectionDelete($id)
{
    $customSection = CustomField::findOrFail($id);
    $customSection->delete();

    Session::flash('success', 'Custom Section deleted successfully.');
    return redirect()->back();
}


public function sectionSorting($type, $listing_id){
    $page_data['sectionSorting'] = CustomField::where('listing_type', $type)->where('listing_id', $listing_id)->orderBy('sorting', 'asc')->get();
    return view('user.agent.custom-field.section_sorting', $page_data);
}

public function SectionSortUpdate(Request $request)
{
    $order = $request->order; 
    $listing_type = $request->listing_type;

    foreach ($order as $index => $id) {
        CustomField::where('id', $id)
            ->where('listing_type', $listing_type)
            ->update([
                'sorting' => $index + 1
            ]);
    }

    return response()->json(['status' => 'success']);
}

}
