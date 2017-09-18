@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <table class="table table-condensed table-responsive table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Key</th>
                    <th>
                        <a href="{{ route('createEditStream') }}" class="btn btn-success btn-xs">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $stream)
                    <tr>
                        <td>{{ $stream->getName() }}</td>
                        <td>{{ $stream->getStreamKey() }}</td>
                        <td>
                            <a href="{{ route('createEditStream', ['id' => $stream->getId()]) }}" class="btn btn-default btn-xs">
                                <span title="Edit" class="glyphicon glyphicon-cog"></span>
                            </a>
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