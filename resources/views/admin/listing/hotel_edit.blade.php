@extends('layouts.admin')
@section('title', get_phrase('Update Listing'))
@section('admin_layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/mapbox-gl.css') }}">
    <script src="{{ asset('assets/frontend/js/mapbox-gl.js') }}"></script>
@endpush
@include('admin.listing.listing_style')
@php
    $tab = isset($tab)?$tab:0;
@endphp
<div class="ol-card">
    <div class="ol-card-body p-3 d-flex align-items-center justify-content-between">
        <h3 class="title fs-16px d-flex align-items-center"> <i class="fi-rr-settings-sliders me-2"></i> {{ucwords($type).' '.get_phrase('Listing Update')}} </h3>
        <a href="{{route('admin.listing.create')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
            <span class="fi-rr-plus"></span>
            <span> {{get_phrase('Add New Listing')}} </span>
        </a>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link {{($tab == 0)?'active':''}}" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true"> {{get_phrase('Basic Info')}} </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false"> {{get_phrase('Address')}} </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link {{($tab == 'feature')?'active':''}}" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false"> {{get_phrase('Features')}} </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link {{($tab == 'room')?'active':''}}" id="room-tab" data-bs-toggle="tab" data-bs-target="#room" type="button" role="tab" aria-controls="room" aria-selected="false"> {{get_phrase('Rooms')}} </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false"> {{get_phrase('Seo')}} </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false"> {{get_phrase('Media')}} </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="claim-tab" data-bs-toggle="tab" data-bs-target="#claim" type="button" role="tab" aria-controls="claim" aria-selected="false"> {{ get_phrase('Claim') }} </button>
            </li>
             {{-- Shop addon --}}
             @if (addon_status('shop') == 1)
             <li class="nav-item" role="presentation">
                <button class="nav-link" id="shop-tab" data-bs-toggle="tab" data-bs-target="#shop" type="button" role="tab" aria-controls="shop" aria-selected="false"> {{ get_phrase('Shop') }} </button>
            </li>
            @endif
            {{-- Shop Addon --}}
             {{-- Custom Field addon --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="customField-tab" data-bs-toggle="tab" data-bs-target="#customField" type="button" role="tab" aria-controls="customField" aria-selected="false"> {{ get_phrase('Custom Field') }} </button>
                </li>
                {{-- Custom Field Addon --}}
        </ul>
        <form action="{{route('admin.listing.update',['type'=>'hotel', 'id'=>$listing->id])}}" id="form-action" method="post" enctype="multipart/form-data" class="position-relative">
            @csrf
            <div class="subMit eSubmit">
                <button type="submit" id="form-action-btn" class="btn ol-btn-outline-secondary"> {{get_phrase('Update')}} </button>
            </div>
            <div class="tab-content pt-3" id="myTabContent">
                <div class="tab-pane fade show {{($tab == 0)?'active':''}}" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <div class="mb-3">
                        <label for="title" class="form-label ol-form-label"> {{get_phrase('Listing title')}} *</label>
                        <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing title')}}" value="{{$listing->title}}">
                    </div>
                    <input type="text" name="category" id="category" value="{{$listing->category}}" class="d-none">
                    <div class="mb-3">
                        <label for="category" class="form-label ol-form-label"> {{get_phrase('category')}} *</label>
                        <select name="category" id="category" class="form-control ol-form-control ol-select2" data-select2-id="select2-data-1-2ry6" tabindex="-1" aria-hidden="true">
                            <option value=""> {{get_phrase('Select listing category')}} </option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $listing->category?'selected':''}}> {{$category->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="price" class="form-label ol-form-label capitalize"> {{get_phrase('Listing Price')}} *</label>
                                <input type="number" name="price" id="price" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing price')}}" value="{{$listing->price}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="bed" class="form-label ol-form-label capitalize"> {{get_phrase('Bed number')}} *</label>
                                <input type="number" name="bed" id="bed" class="form-control ol-form-control" placeholder="{{get_phrase('Enter bed number')}}" value="{{$listing->bed}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="bath" class="form-label ol-form-label capitalize"> {{get_phrase('Bath number')}} *</label>
                                <input type="number" name="bath" id="bath" class="form-control ol-form-control" placeholder="{{get_phrase('Enter bath number')}}" value="{{$listing->bath}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="size" class="form-label ol-form-label"> {{get_phrase('Floor Size')}} *</label>
                                <input type="text" name="size" id="size" class="form-control ol-form-control" placeholder="{{get_phrase('Enter floor size')}}" value="{{$listing->size}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="garage" class="form-label ol-form-label"> {{get_phrase('Garage')}} *</label>
                                <input type="number" name="garage" id="garage" class="form-control ol-form-control" placeholder="{{get_phrase('Enter floor size')}}" value="{{$listing->garage}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="year" class="form-label ol-form-label"> {{get_phrase('Year')}} *</label>
                                <input type="number" name="year" id="year" class="form-control ol-form-control" placeholder="{{get_phrase('Enter floor size')}}" value="{{$listing->year}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="visibility" class="form-label ol-form-label"> {{get_phrase('Visibility')}} *</label>
                                <select name="visibility" id="visibility" class="form-control ol-form-control ol-select2" required data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing visibility')}} </option>
                                    <option value="visible" {{$listing->visibility == 'visible'?'selected':''}}> {{get_phrase('visible')}} </option>
                                    <option value="hidden" {{$listing->visibility == 'hidden'?'selected':''}}> {{get_phrase('Hidden')}} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="is_popular" class="form-label ol-form-label"> {{get_phrase('Type')}} *</label>
                                <select name="is_popular" id="is_popular" class="form-control ol-form-control ol-select2" required data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select Type')}} </option>
                                    <option value="popular" {{$listing->is_popular == 'popular'?'selected':''}}> {{get_phrase('Popular')}} </option>
                                    <option value="top" {{$listing->is_popular == 'top'?'selected':''}}> {{get_phrase('Top')}} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="dimension" class="form-label ol-form-label"> {{get_phrase('Dimension')}} *</label>
                                <input type="text" name="dimension" id="dimension" class="form-control ol-form-control" value="{{$listing->dimension}}" placeholder="{{get_phrase('Enter property dimension')}}" >
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="year" class="form-label ol-form-label"> {{get_phrase('Description')}} </label>
                                <textarea name="description" id="description" cols="30" rows="3" placeholder="{{get_phrase('Write your description')}}" class="form-control">{!!removeScripts($listing->description)!!}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label ol-form-label"> {{get_phrase('Latitude')}} *</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control ol-form-control" value="{{$listing->Latitude}}" placeholder="{{get_phrase('Enter Latitude code')}}" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label ol-form-label"> {{get_phrase('Longitude')}} *</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control ol-form-control" value="{{$listing->Longitude}}" placeholder="{{get_phrase('Enter longitude code')}}" >
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                                <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                                <div id="map" class="rounded h-400" ></div>
                                <script type="text/javascript">
                                    "use strict";
                                       var map = L.map('map').setView([40.706486, -74.014700], 13);
                                       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                           maxZoom: 5,
                                           attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                       }).addTo(map);
                                   
                                       // Create a popup
                                       var popup = L.popup();
                                   
                                       // Define a function to handle map clicks
                                       function onMapClick(e) {
                                           var lat = e.latlng.lat.toFixed(5);  
                                           var lng = e.latlng.lng.toFixed(5);
                                           popup
                                               .setLatLng(e.latlng)
                                               .setContent("You clicked at:<br>Latitude: " + lat + "<br>Longitude: " + lng)
                                               .openOn(map);
                                           document.getElementById('latitude').value = lat;
                                           document.getElementById('longitude').value = lng;
                                       }
                                       map.on('click', onMapClick);
                                   </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="engine_size" class="form-label ol-form-label"> {{get_phrase('Country')}} *</label>
                                <select name="country" id="country" class="form-control ol-form-control ol-select2">
                                    <option value=""> {{get_phrase('Select listing country')}} </option>
                                    @foreach (App\Models\Country::get() as $country)
                                       <option value="{{$country->id}}" {{$listing->country == $country->id?'selected':''}}> {{get_phrase($country->name)}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="city" class="form-label ol-form-label"> {{get_phrase('City')}} *</label>
                                <select name="city" id="city" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value="{{$listing->city}}"> {{App\Models\City::where('id', $listing->city)->first()->name;}} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label ol-form-label"> {{get_phrase('Address')}} *</label>
                        <textarea name="address" id="list_address" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing address')}}" >{!!removeScripts($listing->address)!!}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="post_code" class="form-label ol-form-label"> {{get_phrase('Post Code')}} *</label>
                                <input type="text" name="post_code" id="post_code" class="form-control ol-form-control" value="{{$listing->postal_code}}" placeholder="{{get_phrase('Enter post code')}}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show {{($tab == 'feature')?'active':''}}" id="feature" role="tabpanel" aria-labelledby="feature-tab">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fs-16px title mb-3"> {{get_phrase('Add some listing feature')}} </h5>
                        <a href="javascript:void(0);" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix' =>'admin', 'type'=>'hotel','item'=>'feature','page'=>'listing','listing_id'=>$listing->id])}}', '{{get_phrase('Add New Service')}}')" class="btn ol-btn-primary fs-14px"> {{get_phrase('Add Feature')}} </a>
                    </div>
                    @php
                        $features = App\Models\Amenities::where('type', 'hotel')->where('identifier', 'feature')->get();
                    @endphp
                    <div class="real-estate-feature">
                        @foreach ($features as $key => $feature)
                            <div class="feature-item">
                                <input class="form-check-input d-none" name="feature[]" type="checkbox" value="{{$feature->id}}" id="flexCheckDefau{{$key}}" @if($listing->feature && $listing->feature != 'null' && in_array($feature->id, json_decode($listing->feature))) checked @endif>
                            <label class="form-check-label w-100" onclick="feature_select('{{$key}}')" for="flexCheckDefau{{$key}}">
                                <div class="card mb-3 team-checkbox me-2">
                                    <div class="col-md-12 team-body feature-body">
                                        <div class="card-body py-2 px-2 ms-1">
                                            <div class="icon">
                                                <img  src="{{ asset($feature->image ? '/' . $feature->image : '/image/placeholder.png') }}"    alt=""  class="rounded">
                                              </div>
                                            <span class="text-center d-block w-100"> {{$feature->name}} </span>
                                        </div>
                                        <div class="checked @if($listing->feature && $listing->feature != 'null' && in_array($feature->id, json_decode($listing->feature))) @else d-none @endif" id="feature-checked{{$key}}">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade show {{($tab == 'room')?'active':''}}" id="room" role="tabpanel" aria-labelledby="room-tab">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="fs-16px title mb-3"> {{get_phrase('Add some room')}} </h5>
                        <a href="javascript:void()" onclick="modal('modal-xl', '{{route('admin.add.listing.room',['prefix' =>'admin','id'=>$listing->id,'room_id'=>0, 'page'=>'add'])}}', '{{get_phrase('Add New Room')}}')" class="btn ol-btn-primary fs-14px"> {{get_phrase('Add Room')}} </a>
                    </div>
                    @php
                        $rooms = App\Models\Room::where('listing_id', $listing->id)->get();
                    @endphp
                    <div class="row">
                        @foreach ($rooms as $key => $room)
                        <div class="col-sm-4"> 
                            <input class="form-check-input d-none" name="room[]" type="checkbox" value="{{$room->id}}" id="flckDefault{{$key}}" @if($listing->room && $listing->room != 'null' && in_array($room->id, json_decode($listing->room))) checked @endif>
                            <label class="form-check-label w-100" onclick="room_select('{{$key}}')" for="flckDefault{{$key}}">
                                <div class="card mb-3 eRoom eRoom2 room-checkbox">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img class="object-fit" src="{{ get_all_image('room-images/' . (json_decode($room->image)[0] ?? 'default.jpg')) }}" class="img-fluid rounded-start" alt="Room Image">
                                        </div>
                                        <div class="col-md-8 room-body">
                                            <div class="card-body py-0 px-2 h-100 position-relative">
                                                <p class="card-title mt-3 mb-0 line-3"> {{$room->title}} </p>
                                                <p class="card-text fs-12px"> {{currency($room->price)}} </p>
                                                <div class="text-end position-absulate">
                                                    <a data-bs-toggle="tooltip" 
                                                    data-bs-title="{{  get_phrase('Edit') }}" href="javascript:void(0);" onclick="modal('modal-xl', '{{route('admin.add.listing.room',['prefix' =>'admin','id'=>$listing->id,'room_id'=>$room->id, 'page'=>'edit'])}}', '{{get_phrase('Update New Room')}}')" class="p-1"> <i class="fas fa-edit"></i> </a>
                                                    <a data-bs-toggle="tooltip" 
                                                    data-bs-title="{{  get_phrase('delete') }}" href="javascript:void(0);" onclick="delete_modal('{{route('admin.delete.listing.room',['prefix' =>'admin','id'=>$room->id,'listing_id'=>$listing->id])}}')" class="p-1"> <i class="fas fa-trash-alt"></i> </a>
                                                </div>
                                            </div>
                                            <div class="checked @if($listing->room && $listing->room != 'null' && in_array($room->id, json_decode($listing->room))) @else d-none @endif" id="room-checked{{$key}}">
                                                <i class="fas fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label ol-form-label"> {{get_phrase('Meta Title')}}</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control ol-form-control" value="{{$listing->meta_title}}" placeholder="{{get_phrase('Enter meta title')}}" >
                    </div>
                    <div class="mb-3">
                        <label for="keyword" class="form-label ol-form-label"> {{get_phrase('Meta keywords')}}</label>
                        <input type="text" name="keyword" id="keyword" class="form-control ol-form-control" placeholder="{{get_phrase('Keyword1; keyword2; keyword3;')}}" value="{{$listing->meta_keyword}}">
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label ol-form-label"> {{get_phrase('Meta Description')}} *</label>
                        <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta description')}}" >{{$listing->meta_description}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="og_title" class="form-label ol-form-label"> {{get_phrase('OG title')}}</label>
                        <input type="text" name="og_title" id="og_title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter og title')}}" value="{{$listing->og_title}}">
                    </div>
                    <div class="mb-3">
                        <label for="canonical_url" class="form-label ol-form-label"> {{get_phrase('Canonical URL')}}</label>
                        <input type="text" name="canonical_url" id="canonical_url" class="form-control ol-form-control" placeholder="{{get_phrase('Enter canonical URL')}}" value="{{$listing->canonical_url}}">
                    </div>
                    <div class="mb-3">
                        <label for="og_description" class="form-label ol-form-label"> {{get_phrase('OG Description')}} *</label>
                        <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta description')}}" >{{$listing->og_description}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="json_id" class="form-label ol-form-label"> {{get_phrase('Json ID')}}</label>
                        <input type="text" name="json_id" id="json_id" class="form-control ol-form-control" placeholder="{{get_phrase('Enter json ID')}}" value="{{$listing->json_id}}">
                    </div>
                    <div class="mb-3">
                        <label for="og_image" class="form-label ol-form-label"> {{get_phrase('OG Image')}}</label>
                        <input type="file" name="og_image" id="og_image" class="form-control ol-form-control">
                    </div>
                    
                </div>
                <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                    <div class="row">
                        <div class="col-sm-2">
                            <span> {{get_phrase('Listing Images')}} :</span>
                        </div>
                        <div class="col-sm-10">
                            <div class="d-flex flex-wrap" id="image-container">
                                <!-- Image previews will be dynamically added here -->
                                @foreach(json_decode($listing->image) as $key => $image)
                                <div class="possition_relative" id="image-icon{{$key}}">
                                    <img class="object-fit" src="{{get_all_image('listing-images/'.$image)}}" class="rounded" height="50" width="50">
                                    <a href="javascript:void(0);" onclick="listing_image_delete('{{route('admin.listing.image.delete',['type'=>$type,'id'=>$listing->id, 'image'=>$image])}}', '{{$key}}')"> <i data-bs-toggle="tooltip" 
                                        data-bs-title="{{  get_phrase('delete') }}" class="fas fa-trash-alt"></i> </a>
                                </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                <label for="listing-icon-image" class="file-upload-label">
                                    <div class="label-bg">
                                        <span>{{get_phrase('Click to upload SVG, PNG, JPG, or GIF')}} ({{get_phrase('max 500 x 700px')}})</span>
                                    </div>
                                </label>
                                <input type="file" id="listing-icon-image" name="listing_image[]" class="form-control d-none" multiple>
                            </div>  
                        </div>
                    </div>
                </div>
                {{-- Claim  --}}
                    
                <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab">

                    <div class="card pt-5 pb-5 claimCard">
                        @php 
                          $claimed = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'hotel')->first();
                      @endphp
                    
                    @if($claimed && $claimed->status == 1)
                        <div class="card-body approveClaim">
                            <img src="{{asset('assets/frontend/images/verified.svg')}}" alt="">
                            <p class="text-center mb-2">{{$claimed->user_name}}</p>
                            <p class="text-center mb-2">{{$claimed->user_phone}}</p>
                            <p class="text-center mb-3">{{$claimed->additional_info}}</p>
                            <a href="javascript:;" onclick="delete_modal('{{route('admin.claim-listing.delete',[ 'id'=>$claimed->id])}}')" class="btn ol-btn-outline-secondary d-flex m-auto ">{{get_phrase('Remove verification Status')}}</a>
                        </div>
                    @elseif($claimed && $claimed->status == 0) 
                     <div class="card-body approveClaim">
                        <p class="text-center mb-2">{{$claimed->user_name}}</p>
                        <p class="text-center mb-2">{{$claimed->user_phone}}</p>
                        <p class="text-center mb-3">{{$claimed->additional_info}}</p>
                         <div class="text-center">
                            <a href="javascript:;" onclick="confirm_modal('{{route('admin.claim-listing.approve',['type' => 'hotel', 'listing_id'=>$claimed->id])}}')" class="btn ol-btn-outline-secondary  m-auto ">{{get_phrase('Approve')}}</a>
                            <a href="javascript:;" onclick="delete_modal('{{route('admin.claim-listing.delete',[ 'id'=>$claimed->id])}}')" class="btn ol-btn-outline-secondary  m-auto ">{{get_phrase('Delete')}}</a>
                         </div>
                    </div>
                    @else
                        <div class="card-body">
                            <h5 class="text-center mb-4">{{get_phrase('This directory is not yet verified !')}}</h5>
                            <a href="javascript:;" onclick="edit_modal('modal-md','{{route('admin.claimed_listing.form',['type' =>$listing->type, 'id'=>$listing->id])}}','{{get_phrase('Provide Validity')}}')" class="btn ol-btn-outline-secondary d-flex m-auto ">{{get_phrase('Provide Validity')}}</a>
                        </div>
                    @endif
                          
                    </div>
                </div>
                {{-- Claim  --}}

                {{-- Shop   --}}
                @if (addon_status('shop') == 1)
                <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fs-16px title mb-3 capitalize"> {{ get_phrase('Your  Shop Inventory') }} </h5>
                        <div>
                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.inventory.create', ['prefix' => 'admin', 'type' => 'hotel','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Product') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add New Product') }} </a>
                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.inventory.category.create', ['prefix' => 'admin', 'type' => 'hotel', 'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Category') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Product Category') }} </a>
                        </div>
                    </div>
                    @include('admin.shop.inventory_list')
                </div>
                @endif
                {{-- Shop  --}}
                   {{-- Custom Field   --}}
                    <div class="tab-pane fade" id="customField" role="tabpanel" aria-labelledby="customField-tab">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fs-16px title mb-3 capitalize"> {{ get_phrase('Custom Field') }} </h5>
                            <div>
                                 @php 
                                    $getSorting = App\Models\CustomField::where('listing_type', $type)->where('listing_id', $listing->id)->get();
                                @endphp
                                @if(count($getSorting)> 0)
                                <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.section.sorting', ['prefix' => 'admin', 'type' => 'hotel','listing_id' => $listing->id]) }}', '{{ get_phrase(' Sort Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Sorting') }} </a>
                                   @endif
                                <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.custom-field.create', ['prefix' => 'admin', 'type' => 'hotel','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Custom Field') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Type') }} </a>
                            </div>
                        </div>
                         @include('admin.custom-field.index')
                    </div>
                    {{-- Custom Field  --}}


            </div>
        </form>
    </div>
</div>
@include('admin.listing.listing_script')
<script>
"use strict";
document.getElementById('listing-floor-plan').addEventListener('change', function(event) {
    const imageContainer = document.getElementById('floor-plan-container');
    const files = event.target.files;

    for (const file of files) {
        if (!['image/jpeg', 'image/png', 'image/svg+xml', 'image/gif'].includes(file.type)) {
            alert('Please upload an image file (SVG, PNG, JPG, or GIF).');
            continue;
        }

        const reader = new FileReader();
        
        reader.onload = function(e) {
            const imageIcon = document.createElement('div');
            imageIcon.classList.add('position-relative', 'm-2');
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Selected image';
            img.classList.add('rounded');
            img.style.height = '50px';
            img.style.width = '50px';
            
            const trashIcon = document.createElement('i');
            trashIcon.classList.add('fas', 'fa-trash-alt', 'position-absolute', 'floor-plan-icon', 'top-0', 'end-0', 'text-danger', 'm-1', 'cursor-pointer');
            trashIcon.style.cursor = 'pointer';
            trashIcon.addEventListener('click', function() {
                imageIcon.remove();
            });

            imageIcon.appendChild(img);
            imageIcon.appendChild(trashIcon);
            imageContainer.appendChild(imageIcon);
        }
        
        reader.readAsDataURL(file);
    }
});

    $("#form-action-btn").on('click', function() {
        event.preventDefault(); 
        var listing_category = $("#category").val();
        if(!listing_category){
            warning('Listing category is required');
        }
        var listing_title = $("#title").val();
        if(!listing_title){
            warning('Listing title is required');
        }
        var listing_price = $("#price").val();
        if(!listing_price){
            warning('Listing price is required');
        }
        var listing_bed = $("#bed").val();
        if(!listing_bed){
            warning('Listing bed is required');
        }
        var listing_bath = $("#bath").val();
        if(!listing_bath){
            warning('Listing bath is required');
        }
        var listing_size = $("#size").val();
        if(!listing_size){
            warning('Listing size is required');
        }
        var listing_garage = $("#garage").val();
        if(!listing_garage){
            warning('Listing garage is required');
        }
        var listing_year = $("#year").val();
        if(!listing_year){
            warning('Listing Year is required');
        }
        
        var listing_country = $("#country").val();
        if(!listing_country){
            warning('Listing country is required');
        }
        var listing_city = $("#city").val();
        if(!listing_city){
            warning('Listing city is required');
        }
        var listing_address = $("#list_address").val();
        if(!listing_address){
            warning('Listing address is required');
        }
        var listing_post_code = $("#post_code").val();
        if(!listing_post_code){
            warning('Listing post code is required');
        }
        var listing_latitude = $("#latitude").val();
        if(!listing_latitude){
            warning('Listing latitude is required');
        }
        var listing_longitude = $("#longitude").val();
        if(!listing_longitude){
            warning('Listing longitude is required');
        }
        var listing_visibility = $("#visibility").val();
        if(!listing_visibility){
            warning('Listing visibility is required');
        }
        var listing_dimension = $("#dimension").val();
        if(!listing_dimension){
            warning('Listing dimension is required');
        }
        if(listing_year && listing_garage && listing_size && listing_bath && listing_bed && listing_price && listing_title && listing_category && listing_country && listing_city && listing_address && listing_post_code && listing_latitude && listing_longitude && listing_visibility && listing_dimension){
            $("#form-action").trigger('submit');
        }

    })
</script>

<script>
    "use strict";
    $(document).ready(function() {
    $("#country").on('change', function() {
        var country = $("#country").val();
        var url = "{{ route('admin.country.city', ['id' => ':id']) }}";
        url = url.replace(':id', country);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                var cityDropdown = $("#city");
                cityDropdown.html('<option value="">{{ get_phrase("City") }}</option>');
                $.each(result, function(index, city) {
                    cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                });
            },
            error: function(xhr) {
               
            }
        });
    });
});




</script>

<script>
      document.getElementById('listing-icon-image').addEventListener('change', function(event) {
        const imageContainer = document.getElementById('image-container');
        const files = event.target.files;

        for (const file of files) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const imageIcon = document.createElement('div');
                imageIcon.classList.add('image-icon');
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Selected image';
                
                const trashIcon = document.createElement('i');
                trashIcon.classList.add('fas', 'fa-trash-alt');
                trashIcon.addEventListener('click', function() {
                    imageIcon.remove();
                });

                imageIcon.appendChild(img);
                imageIcon.appendChild(trashIcon);
                imageContainer.appendChild(imageIcon);
            }
            
            reader.readAsDataURL(file);
        }
    }); 
</script>
@endsection