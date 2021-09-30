@extends('beautymail::templates.sunny')

@section('content')

@include ('beautymail::templates.sunny.heading' , [
'heading' => 'Reminder - ' . $report,
'level' => 'h1'
])

@include('beautymail::templates.sunny.contentStart')

<h4 class="secondary"><strong>Hello {{ $adjuster }}</strong></h4>
<p>{{ $content }}</p>

@include('beautymail::templates.sunny.contentEnd')

@include('beautymail::templates.sunny.button', [
'title' => 'Click',
'link' => 'http://axisers.com/reason'
])

@stop