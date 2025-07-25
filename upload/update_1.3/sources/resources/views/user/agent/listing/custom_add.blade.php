<div class="ca-content-card p-4">
    <ul class="nav nav-pills cap-nav-pills mb-20px" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="pills-basic-info-tab" data-bs-toggle="pill" data-bs-target="#pills-basic-info" type="button" role="tab" aria-controls="pills-basic-info" aria-selected="true">{{get_phrase('Basic Info')}}</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill" data-bs-target="#pills-address" type="button" role="tab" aria-controls="pills-address" aria-selected="false">{{get_phrase('Address')}}</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo" type="button" role="tab" aria-controls="pills-seo" aria-selected="false">{{get_phrase('Seo')}}</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-media-tab" data-bs-toggle="pill" data-bs-target="#pills-media" type="button" role="tab" aria-controls="pills-media" aria-selected="false">{{get_phrase('Media')}}</button>
        </li>
    </ul>
    <form class="position-relative" action="{{route('user.listing.store',['type'=>$type])}}" id="form-action" method="post" enctype="multipart/form-data">
        @csrf
         @php 
        $type_id = App\Models\CustomType::where('slug', $type)->first();  
        @endphp
        <input type="hidden" name="type_id" value="{{$type_id->id}}">
    <div class="subMit">
        <button type="submit" id="form-action-btn" class="cap2-btn-primary cap-btn-sm gap-1"> {{get_phrase('Create')}} </button>
    </div>
    <input type="hidden" name="is_agent" value="1">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-basic-info" role="tabpanel" aria-labelledby="pills-basic-info-tab" tabindex="0">
            <div class="mb-2">
                <label for="title" class="form-label cap-form-label"> {{get_phrase('Listing title')}} *</label>
                <input type="text" name="title" id="title" class="form-control cap-form-control" placeholder="{{get_phrase('Enter listing title')}}" >
            </div>
            <div class="mb-2">
                <label for="category" class="form-label cap-form-label"> {{get_phrase('category')}} *</label>
                <select name="category" id="category" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6" tabindex="-1" aria-hidden="true">
                    <option value=""> {{get_phrase('Select listing category')}} </option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}"> {{$category->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-2">
                        <label for="visibility" class="form-label cap-form-label"> {{get_phrase('Visibility')}} *</label>
                        <select name="visibility" id="visibility" class="at-select2 cap-select2 select2-hidden-accessible" aria-hidden="true">
                            <option value=""> {{get_phrase('Select listing visibility')}} </option>
                            <option value="visible"> {{get_phrase('visible')}} </option>
                            <option value="hidden"> {{get_phrase('Hidden')}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-2">
                        <label for="is_popular" class="form-label cap-form-label"> {{get_phrase('Type')}} *</label>
                        <select name="is_popular" id="is_popular" class="at-select2 cap-select2 select2-hidden-accessible" aria-hidden="true" required>
                            <option value=""> {{get_phrase('Select type')}} </option>
                            <option value="top"> {{get_phrase('Top')}} </option>
                            <option value="popular"> {{get_phrase('Popular')}} </option>
                        </select>
                    </div>
                </div> 
                 <div class="col-sm-12">
                    <div class="mb-2">
                        <label for="description" class="form-label cap-form-label"> {{get_phrase('Description')}} </label>
                        <textarea name="description" id="description" cols="30" rows="3" placeholder="{{get_phrase('Write your description')}}" class=" form-control cap-form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <label for="latitude" class="form-label cap-form-label"> {{get_phrase('Latitude')}} *</label>
                            <input type="text" name="latitude" id="latitude" class="form-control cap-form-control" placeholder="{{get_phrase('Enter Latitude code')}}" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-2">
                            <label for="longitude" class="form-label cap-form-label"> {{get_phrase('Longitude')}} *</label>
                            <input type="text" name="longitude" id="longitude" class="form-control cap-form-control" placeholder="{{get_phrase('Enter longitude code')}}" >
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                    <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                    <div id="map" class="rounded h-400"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab" tabindex="0">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-2">
                        <label for="engine_size" class="form-label cap-form-label"> {{get_phrase('Country')}} *</label>
                        <select name="country" id="country" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6c" tabindex="-1" aria-hidden="true">
                            <option value=""> {{get_phrase('Select listing country')}} </option>
                            @foreach (App\Models\Country::get() as $country)
                                <option value="{{$country->id}}"> {{get_phrase($country->name)}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-2">
                        <label for="city" class="form-label cap-form-label"> {{get_phrase('City')}} *</label>
                        <select name="city" id="city" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryci6" tabindex="-1" aria-hidden="true">
                            <option value=""> {{get_phrase('Select listing city')}} </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label for="address" class="form-label cap-form-label"> {{get_phrase('Address')}} *</label>
                <textarea name="address" id="address" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter listing address')}}" ></textarea>
            </div>
            
            <div class="mb-2">
                <label for="post_code" class="form-label cap-form-label"> {{get_phrase('Post Code')}} *</label>
                <input type="text" name="post_code" id="post_code" class="form-control cap-form-control" placeholder="{{get_phrase('Enter post code')}}" >
            </div>
        </div>
        <div class="tab-pane fade" id="pills-seo" role="tabpanel" aria-labelledby="pills-seo-tab" tabindex="0">
            <div class="mb-2">
                <label for="meta_title" class="form-label cap-form-label"> {{get_phrase('Meta Title')}}</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control cap-form-control" placeholder="{{get_phrase('Enter meta title')}}" >
            </div>
            <div class="mb-2">
                <label for="keyword" class="form-label cap-form-label"> {{get_phrase('Meta keywords')}}</label>
                <input type="text" name="keyword" id="keyword" class="form-control cap-form-control" placeholder="{{get_phrase('Keyword1; keyword2; keyword3;')}}" >
            </div>
            <div class="mb-2">
                <label for="meta_description" class="form-label cap-form-label"> {{get_phrase('Meta Description')}} </label>
                <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter meta description')}}" ></textarea>
            </div>
            <div class="mb-2">
                <label for="og_title" class="form-label cap-form-label"> {{get_phrase('OG title')}}</label>
                <input type="text" name="og_title" id="og_title" class="form-control cap-form-control" placeholder="{{get_phrase('Enter og title')}}" >
            </div>
            <div class="mb-2">
                <label for="canonical_url" class="form-label cap-form-label"> {{get_phrase('Canonical URL')}}</label>
                <input type="text" name="canonical_url" id="canonical_url" class="form-control cap-form-control" placeholder="{{get_phrase('Enter canonical URL')}}" >
            </div>
            <div class="mb-2">
                <label for="og_description" class="form-label cap-form-label"> {{get_phrase('OG Description')}} </label>
                <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter meta description')}}" ></textarea>
            </div>
            <div class="mb-2">
                <label for="json_id" class="form-label cap-form-label"> {{get_phrase('Json ID')}}</label>
                <input type="text" name="json_id" id="json_id" class="form-control cap-form-control" placeholder="{{get_phrase('Enter json ID')}}">
            </div>
            <div class="mb-2">
                <label for="og_image" class="form-label cap-form-label"> {{get_phrase('OG Image')}}</label>
                <input type="file" name="og_image" id="og_image" class="form-control cap-form-control">
            </div>
        </div>
        <div class="tab-pane fade" id="pills-media" role="tabpanel" aria-labelledby="pills-media-tab" tabindex="0">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label class="form-label cap-form-label"> {{get_phrase('Listing Images')}} :</label>
                </div>
                <div class="col-sm-9">
                    <div class="d-flex flex-wrap" id="image-container">
                        <!-- Image previews will be dynamically added here -->
                    </div>
                    
                    <div class="upload__box">
                        <div class="upload__img-wrap"></div>
                        <div class="upload__btn-box">
                            <label class="upload__btn">
                                <div class="d-flex justify-content-center mb-2">
                                    <img src="{{asset('assets/frontend/images/icons/cloud-minus-32.svg')}}" alt="">
                                </div>
                                <p class="upload-btn-subtitle">{{get_phrase('Upload Product Image')}}</p>
                                <input type="file" name="listing_image[]" multiple data-max_length="20" class="upload__inputfile" id="image-input">
                            </label>
                        </div>
                    </div>                    

                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@include('user.agent.listing.script')
<script>
    "use strict";
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
        
        var listing_listing_icon_image = $("#image-input").val();
        if(!listing_listing_icon_image){
            warning('Listing image is required');
        }
        var listing_country = $("#country").val();
        if(!listing_country){
            warning('Listing country is required');
        }
        var listing_city = $("#city").val();
        if(!listing_city){
            warning('Listing city is required');
        }
        var listing_address = $("#address").val();
        if(!listing_address){
            warning('Listing address is required');
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
        
        var listing_is_popular = $("#is_popular").val();
        if(!listing_is_popular){
            warning('Listing Type is required');
        }
        if(listing_listing_icon_image   && listing_title && listing_category && listing_country && listing_city && listing_address  && listing_latitude && listing_longitude && listing_visibility  && listing_is_popular){
            $("#form-action").trigger('submit');
        }
    })
</script>