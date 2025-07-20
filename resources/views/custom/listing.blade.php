{{-- Custom listing predloga --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ \$listing->title }}</h1>
    @if(\$listing->website_url)
        <p><strong>Spletna stran:</strong> 
            <a href="{{ \$listing->website_url }}" target="_blank" rel="nofollow">
                {{ parse_url(\$listing->website_url, PHP_URL_HOST) ?? \$listing->website_url }}
            </a>
        </p>
    @endif
</div>
@endsection
