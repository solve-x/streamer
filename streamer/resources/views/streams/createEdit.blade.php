@extends('layouts.app')

@section('content')

    <form class="form-horizontal" method="POST" action="{{ route('createEditStream') }}">
        <input type="hidden" id="id" name="id" value="{{ $model->getId()  }}"/>
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="type">Tip</label>
                </div>
                <div class="col-md-10">
                    <select class="form-control" id="type" name="type">
                        @foreach($streamTypes as $item)
                            <option value="{{ $item->getId() }}" <?php if ($model->getType() === $item) echo 'selected'; ?>>
                                {{ $item->getLabel() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="name">Naziv</label>
                </div>
                <div class="col-md-10">
                    <input name="name" id="name" value="{{ $model->getName() }}" class="form-control" />
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="streamKey">Ključ</label>
                </div>
                <div class="col-md-10">
                    <input name="streamKey" id="streamKey" value="{{ $model->getStreamKey() }}" class="form-control" />
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="isLive">V živo</label>
                </div>
                <div class="col-md-10">
                    <input type="checkbox" name="isLive" id="isLive" <?php if ($model->isLive()) echo 'checked'; ?> />
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-offset-2">
                    <div class="input-group">
                        <input type="submit" class="btn btn-success" value="Shrani" />
                        <a href="#" onclick="warnDeleteStream()" class="btn btn-warning">Izbriši</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        function warnDeleteStream() {
            if (!confirm('Ali res želite izbrisati prenos?')) {
                return;
            }

            let url = '{{ route('deleteStream', ['id' => $model->getId()]) }}';
            $.ajax(url, {
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                   id: $('hidden[id="id"]').val()
                },
                success: function (response) {
                    window.location = response.redirect;
                },
                error: function () {
                    alert('Prenosa ni bilo možno izbrisati!');
                }
            });
        }
    </script>
@endsection