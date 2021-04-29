@extends('base')
@section('title', 'Error')

@section('content')

    <div id="500" class="container" style="text-align: center; padding: 35px 0">
        <br/>
        <h1 style="text-align: center">There was an Error</h1>
        <h3 style="text-align: center">
            Looks like something went wrong with processing your request, please try again.
        </h3>
        @auth
            <br/><hr/><br/>
            <h2>Authorized User, Displaying Error:</h2>
            <h3>{{ $exception->getMessage() }}</h3>
        @endauth
    </div>

@endsection
