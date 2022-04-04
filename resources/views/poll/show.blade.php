@extends('layouts.app')

@section('meta')
    <title>{{ __("Poll: :poll", ['poll' => $poll->title]) }}</title>
@endsection

@section('content')
    <main id="app" class="container bg-white p-8 max-w-[550px] mx-auto rounded-lg shadow-md">
        <voting-form slug="{{ $poll->slug }}"></voting-form>
    </main>    
@endsection