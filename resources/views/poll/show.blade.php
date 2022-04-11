@extends('layouts.app')

@section('meta')
    <title>{{ __("Poll: :poll", ['poll' => $poll->title]) }}</title>
@endsection

@section('content')
    <main id="app" class="mx-4 bg-white w-full p-8 max-w-[90%] md:max-w-[550px] lg:max-w-[40%] md:mx-auto rounded-lg shadow-md">
        <voting-form slug="{{ $poll->slug }}"></voting-form>
    </main>    
@endsection