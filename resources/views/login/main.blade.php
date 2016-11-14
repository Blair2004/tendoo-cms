@extends('login/template')

@section('document_title' ) Sign in &mdash; Tendoo CMS @endsection

@section('document_content')
    <div class="container d-table">
        <div class="d-100vh-va-middle">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card-group">
                        <div class="card p-2">
                            <div class="card-block">
                                <h1>Login</h1>
                                <p class="text-muted">Sign In to your account</p>
                                {!! Form::open( [ 'url' =>  'login/log-user' ] )!!}
                                    <!-- User Name  -->
                                    <div class="controls">
                                        <div class="input-prepend input-group mb-1 {!! $errors->has( 'username' ) ? 'has-danger' : '' !!}">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            {!! Form::text( 'username', null, [ 'class' => 'form-control', 'placeholder' => 'Username' ] ) !!}
                                        </div>
                                        {!! $errors->first( 'username', '<p class="help-block">:message</p>' ) !!}
                                    </div>

                                    <!-- User Name  -->
                                    <div class="controls">
                                        <div class="input-prepend input-group mb-1 {!! $errors->has( 'user_pwd' ) ? 'has-danger' : '' !!}">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            {!! Form::password( 'user_pwd', [ 'class' => 'form-control', 'placeholder' => 'Password' ] ) !!}
                                        </div>
                                        {!! $errors->first( 'user_pwd', '<p class="help-block">:message</p>' ) !!}
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-primary px-2">Login</button>
                                        </div>
                                        <div class="col-xs-6 text-xs-right">
                                            <button type="button" class="btn btn-link px-0">Forgot password?</button>
                                        </div>
                                    </div>

                                {!! Form::close()!!}
                            </div>
                        </div>
                        <div class="card card-inverse card-primary py-3 hidden-md-down" style="width:44%">
                            <div class="card-block text-xs-center">
                                <div>
                                    <h2>Sign up</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <button type="button" class="btn btn-primary active mt-1">Register Now!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
