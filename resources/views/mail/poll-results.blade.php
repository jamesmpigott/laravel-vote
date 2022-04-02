@component('mail::message')
# {{ __("Poll Results") }}
## {{ $poll->title }} 

@component('mail::table')
| Option         | Count         |
| :------------- |:-------------:|
@foreach($poll->options as $option)
| {{ $option->value }} | {{ $option->votes()->count() }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => route('poll.show', $poll)])
{{ __("View Poll") }}
@endcomponent

@endcomponent
