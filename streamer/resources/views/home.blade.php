@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <video style="display: none;" id=example-video width=960 height=540 class="video-js vjs-default-skin" controls>
                </video>
                <div class="text-center">
                    <img id="imgOffline" style="display: none; margin-left: auto; margin-right: auto;" src="https://cdn.meme.am/instances/500x/37795699/stream-currently-offline-too-bad.jpg" />
                    <img id="imgNotFound" style="display: none; margin-left: auto; margin-right: auto;" src="https://i.pinimg.com/736x/eb/bd/06/ebbd06c474eb0a1096c16991a441ad52--scores-wednesday.jpg" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function () {

        let url = '{{ route('isStreamLive', ['key' => 'mystream']) }}';
        $.ajax(url, {
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                streamKey: 'mystream'
            },
            success: (response) => {

                if (response) {
                    let src = '<source src="http://localhost:1936/stream/live/mystream.m3u8" type="application/x-mpegURL">';
                    let videoElement = $('video')[0];

                    videoElement.innerHTML = src;
                    videoElement.style.display = 'block';
                    videojs('example-video').play();
                    return;
                }

                $('#imgOffline').css('display', 'block');
            },
            error: (response) => {
                if (404 === response.status) {
                    $('#imgNotFound').css('display', 'block');
                } else {
                    alert('Could not check stream state!');
                }
            }
        });


    });
</script>
@endsection