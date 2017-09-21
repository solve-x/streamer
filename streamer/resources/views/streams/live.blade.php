@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="margin: 0 auto;">
            <img id="imgOffline" width="800" height="600" style="display: none; margin: 0 auto;" src="https://nerdordie.com/wp-content/uploads/2017/03/Reloaded_StreamOffline.jpg" />
            <img id="imgNotFound" style="display: none; margin: 0 auto;" src="https://i.pinimg.com/736x/eb/bd/06/ebbd06c474eb0a1096c16991a441ad52--scores-wednesday.jpg" />
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <video style="display: none;" id=example-video width=960 height=540 class="video-js vjs-default-skin" controls>
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {

            let streamKey = "{{ $model->getStreamKey() }}";
            let url = '{{ route('isStreamLive', ['key' => $model->getStreamKey()]) }}';
            $.ajax(url, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    streamKey: streamKey
                },
                success: (response) => {

                    if (response) {
                        let srcUrl = '{{ route('liveStreamParts', ['streamPart' => "{$model->getStreamKey()}.m3u8"]) }}';
                        let src = '<source src="' + srcUrl + '" type="application/x-mpegURL">';
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