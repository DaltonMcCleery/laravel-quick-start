@extends('emails.email_wrapper')
@section('title'){{ $subject  }}@endsection
@section('body')
    <p>
        You have a new Contact Message! To view this submission on the website, please click
        <a href="{{ url('/manage') }}">here</a> and login.
    </p>
    <hr/>
    <ul>
        <li><strong>Name</strong>: {{ $body['name'] }}</li>
        <li><strong>Email</strong>: {{ $body['email'] }}</li>
        <li><strong>Phone</strong>: {{ $body['phone'] }}</li>
    </ul>
@endsection
