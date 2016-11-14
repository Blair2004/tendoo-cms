@extends('setup/template')

@section( 'document_title' ) Welcome Page &mdash;  Tendoo @endsection

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
                            <h4>Setup</h4>
                            <p class="text-muted">Welcome on the installation page of Tendoo CMS. You're ready to go, click  to continue.</p>
                            <a href="/setup/1" class="btn btn-block btn-primary">Start Installation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
