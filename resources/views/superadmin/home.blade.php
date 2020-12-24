@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">{{ explode('.', Route::currentRouteName())[0] }}</h1>
</div>
@endsection
