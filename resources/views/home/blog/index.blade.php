@extends('home.master')
@section('content')
    <section class="blgLstSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <blog-archive :allarticledata="{{json_encode($articelData)}}"></blog-archive>
                </div>
            </div>
        </div>
    </section>
@endsection
