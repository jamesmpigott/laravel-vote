@extends('layouts.app')

@section('meta')
    <title>{{ __("Poll: :poll", ['poll' => $poll->title]) }}</title>
@endsection

@section('content')
    <voting-form slug="{{ $poll->slug }}"></voting-form>
@endsection