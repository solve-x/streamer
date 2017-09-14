@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <video id=example-video width=960 height=540 class="video-js vjs-default-skin" controls>
                    <source
                            src="http://localhost:1936/stream/live/mystream.m3u8"
                            type="application/x-mpegURL">
                </video>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    videojs('example-video').play();
</script>
@endsection