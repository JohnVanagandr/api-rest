@extends('layouts.authorized')

@section('content')
    <div class="container">
        <div class="row">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card card-default">
                            <div class="card-header">
                                Authorization Request
                            </div>
                            <div class="card-body">
                                <!-- Introduction -->
                                <p><strong>{{ $client->name }}</strong> is requesting permission to
                                    access your account.</p>

                                <!-- Scope List -->
                                @if (count($scopes) > 0)
                                    <div class="scopes">
                                        <p><strong>This application will be able to:</strong></p>

                                        <ul>
                                            @foreach ($scopes as $scope)
                                                <li>{{ $scope->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex gap-5 justify-content-center">
                                    <!-- Authorize Button -->
                                    <form method="post" action="{{ route('passport.authorizations.approve') }}">
                                        @csrf

                                        <input type="hidden" name="state" value="{{ $request->state }}">
                                        <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                        <button type="submit" class="btn btn-success btn-lg btn-approve">Authorize</button>
                                    </form>

                                    <!-- Cancel Button -->
                                    <form method="post" action="{{ route('passport.authorizations.deny') }}">
                                        @csrf
                                        @method('DELETE')

                                        <input type="hidden" name="state" value="{{ $request->state }}">
                                        <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                        <button class="btn btn-danger btn-lg">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
