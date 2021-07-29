@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="container pdf">
                <iframe  class="responsive-iframe"  src="/files/{{$file->files->filename}}"> </iframe>
        </div>
              
        </div>
    </div>
</div>
@endsection
