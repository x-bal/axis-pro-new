@extends('beautymail::templates.sunny')

@section('content')

@include ('beautymail::templates.sunny.heading' , [
'heading' => 'Reminder - ' . $report,
'level' => 'h1'
])

@include('beautymail::templates.sunny.contentStart')

<h3 class="secondary"><strong>Hello {{ $adjuster }}</strong></h3>
<p>{{ $content }}</p>

@include('beautymail::templates.sunny.contentEnd')

@include('beautymail::templates.minty.button', ['text' => 'Click', 'link' => route('reason')])

@stop