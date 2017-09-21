@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-condensed table-responsive table-striped">
                <thead>
                <tr>
                    <th>Stream</th>
                    <th>Key</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($model as $stream)
                    <tr>
                        <td>{{ $stream->getName() }}</td>
                        <td>{{ $stream->getStreamKey() }}</td>
                        <td>
                            <?php if ($stream->isLive()) { ?>
                            <a href="{{ route('liveStream', ['streamKey' => $stream->getStreamKey()]) }}">
                                <span title="V živo" class="glyphicon glyphicon-play-circle"></span>
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
@endsection