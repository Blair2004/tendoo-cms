@extends('setup/template')

@section( 'document_title' ) Database Configuration &mdash;  Tendoo @endsection

@section('document_content')
    <div class="container d-table">
        <div class="d-100vh-va-middle">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card mx-2">
                        <div class="card-header">
                            <h3 class="text-center">Ten<small>DOO</small></h3>
                        </div>
                        <div class="card-block p-2">
                            <h4>Application Configuration</h4>
                            <p>Application configuration</p>
                            {!! Form::open( [
                                'url' =>   'setup/app'
                            ])!!}

                            <!-- App Name  -->
                            <div class="controls">
                                <div class="input-prepend input-group mb-1 {!! $errors->has( 'app_name' ) ? 'has-danger' : '' !!}">
                                    <span class="input-group-addon"><i class="fa fa-vcard-o"></i></span>
                                    {!! Form::text( 'app_name', null, [ 'class' => 'form-control', 'placeholder' => 'Application Name' ] ) !!}
                                </div>
                                {!! $errors->first( 'app_name', '<p class="help-block">:message</p>' ) !!}
                            </div>

                            <!-- Admin User Name -->
                            <div class="controls">
                                <div class="input-prepend input-group mb-1 {!! $errors->has( 'admin_name' ) ? 'has-danger' : '' !!}">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text( 'admin_name', null, [ 'class' => 'form-control', 'placeholder' => 'Admin Name' ] ) !!}
                                </div>
                                {!! $errors->first( 'admin_name', '<p class="help-block">:message</p>' ) !!}
                            </div>

                            <!-- Admin User Email -->
                            <div class="controls">
                                <div class="input-prepend input-group mb-1 {!! $errors->has( 'admin_email' ) ? 'has-danger' : '' !!}">
                                    <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                    {!! Form::text( 'admin_email', null, [ 'class' => 'form-control', 'placeholder' => 'Email' ] ) !!}
                                </div>
                                {!! $errors->first( 'admin_email', '<p class="help-block">:message</p>' ) !!}
                            </div>

                            <!-- Admin Password -->
                            <div class="controls">
                                <div class="input-prepend input-group mb-1 {!! $errors->has( 'admin_pwd' ) ? 'has-danger' : '' !!}">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    {!! Form::text( 'admin_pwd', null, [ 'class' => 'form-control', 'placeholder' => 'Password' ] ) !!}
                                </div>
                                {!! $errors->first( 'admin_pwd', '<p class="help-block">:message</p>' ) !!}
                            </div>

                            <!-- Host User Name -->
                            <div class="controls">
                                <div class="input-prepend input-group mb-1 {!! $errors->has( 'admin_pwd_confirm' ) ? 'has-danger' : '' !!}">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    {!! Form::text( 'admin_pwd_confirmation', null, [ 'class' => 'form-control', 'placeholder' => 'Confirm' ] ) !!}
                                </div>
                                {!! $errors->first( 'admin_pwd_confirmation', '<p class="help-block">:message</p>' ) !!}
                            </div>

                            {!! Form::submit( 'Install & Create Admin', [ 'class' => 'btn btn-primary pull-right' ] ) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
