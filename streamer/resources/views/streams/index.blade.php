@extends('layouts.app')

@section('content')
<div class="container">
    @include('dialogs.addEditStream')
    <div class="row">
        <table class="table table-condensed table-responsive table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Key</th>
                    <th>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addEditStream">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $stream)
                    <tr>
                        <td>{{ $stream->getName() }}</td>
                        <td>{{ $stream->getStreamKey() }}</td>
                        <td>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#addEditStream">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
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