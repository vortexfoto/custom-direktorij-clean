
<style>
    .text-area{
        height: 300px;
    }
</style>
<form action="{{route('admin.newsletters.store')}}" method="post">
    @csrf

    <div class="mb-3">
        <label for="subject" class="form-label ol-form-label">{{ get_phrase('Subject') }}</label>
        <input type="text" name="subject" class="form-control ol-form-control" id="subject" placeholder="{{ get_phrase('Subject') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="description"  class="form-control ol-form-control text-area" required></textarea>
    </div>

    <div class="fpb-7">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Submit') }}</button>
    </div>
</form>


