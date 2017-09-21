@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <table class="table table-condensed table-responsive table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th></th>
                    <th>
                        <a href="#" class="btn btn-success btn-xs">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $user)
                    <tr>
                        <td>{{ $user->getName() }}</td>
                        <td>{{ $user->getEmail() }}</td>
                        <td>
                            <?php if ($user->isLockout()) { ?>
                            <span title="Račun zaklenjen" class="glyphicon glyphicon-lock"></span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="{{ route('createEditUser', ['id' => $user->getId()]) }}" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-pencil"></span>
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