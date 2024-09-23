@extends('layouts.auth')

@section('title', 'Login')

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>


        <div class="card-body">
            @include('components.partials.alerts.list-error')
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate autocomplete="off">
                @csrf
                <x-partials.elements.form-group.input label="Username" name="username" id="username" :value="old('username')" />

                <x-partials.elements.form-group.input type="password" label="Password" name="password" id="password"
                    :value="old('password')" />

                <div class="d-inline">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
