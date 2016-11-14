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
                            <h4>Database configuration</h4>
                            <p class="text-muted">Before using Tendoo CMS, you need to provide your database information.</p>

                            @if(session()->has('status') )
            					<div class="alert alert-danger">{!! session('message') !!}</div>
            				@endif

                            {{ Form::open( [
                                'url' =>   'setup/database'
                            ])}}

                            <!-- Host Name  -->
                            <div class="input-group mb-1  {!! $errors->has( 'host_name' ) ? 'has-danger' : '' !!}">
                                <span class="input-group-addon"><i class="fa fa-server"></i></span>
                                {{ Form::text( 'host_name', null, [ 'class' => 'form-control', 'placeholder' => 'Host' ] ) }}
                            </div>

                            {!! $errors->first( 'host_name', '<p class="help-block mb-1">:message</p>' ) !!}


                            <!-- Host User Name -->
                            <div class="input-group mb-1 {!! $errors->has( 'user_name' ) ? 'has-danger' : '' !!}">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{ Form::text( 'user_name', null, [ 'class' => 'form-control', 'placeholder' => 'User Name' ] ) }}
                            </div>

                            {!! $errors->first( 'user_name', '<p class="help-block mb-1">:message</p>' ) !!}

                            <!-- Host User Password -->
                            <div class="input-group mb-1  {!! $errors->has( 'user_pwd' ) ? 'has-danger' : '' !!}">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                {{ Form::text( 'user_pwd', null, [ 'class' => 'form-control', 'placeholder' => 'User Password' ] ) }}
                            </div>

                            {!! $errors->first( 'user_pwd', '<p class="help-block mb-1">:message</p>' ) !!}

                            <!-- Host User Name -->
                            <div class="input-group mb-1  {!! $errors->has( 'db_name' ) ? 'has-danger' : '' !!}">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                {{ Form::text( 'db_name', null, [ 'class' => 'form-control', 'placeholder' => 'Database Name' ] ) }}
                            </div>

                            {!! $errors->first( 'db_name', '<p class="help-block mb-1">:message</p>' ) !!}

                            <!-- Database Prefix -->
                            <div class="input-group mb-1  {!! $errors->has( 'db_prefix' ) ? 'has-danger' : '' !!}">
                                    <span class="input-group-addon"><i class="fa fa-table"></i></span>
                                {{ Form::text( 'db_prefix', null, [ 'class' => 'form-control', 'placeholder' => 'Tables Prefix' ] ) }}
                            </div>

                            {!! $errors->first( 'db_prefix', '<p class="help-block mb-1">:message</p>' ) !!}


                            {{ Form::submit( 'Save Database', [ 'class' => 'btn btn-primary pull-right' ] ) }}

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
