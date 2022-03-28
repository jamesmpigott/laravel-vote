@extends('layouts.app')

@section('content')
    <voting-form slug="{{ $poll->slug }}"></voting-form>
@endsection