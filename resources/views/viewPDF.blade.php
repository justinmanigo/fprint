@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="pdf">
        <div class="col-md-12">
        <div class="container pdf"> 
                <iframe  class="responsive-iframe"  src="{{asset('files/'.$file->files->filename)}}"> </iframe> 
        </div>
        </div>
    </div>
</div>
@endsection
