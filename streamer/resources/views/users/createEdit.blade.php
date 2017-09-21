@extends('layouts.app')

@section('content')

    <form class="form-horizontal" method="POST" action="{{ route('createEditUser') }}">

        <div class="col-md-5 col-md-offset-2">
            <h4>Ustvari uporabnika</h4>
            <hr>
        </div>

        <input type="hidden" id="id" name="id" value="{{ $model->getId()  }}"/>
        {{ csrf_field() }}
        <div class="col-md-5 col-md-offset-2">
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="name">Ime</label>
                </div>
                <div class="col-md-10">
                    <input name="name" id="name" value="{{ $model->getName() }}" class="form-control" />
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="email">Up. ime</label>
                </div>
                <div class="col-md-10">
                    <input name="email" id="email" value="{{ $model->getEmail() }}" class="form-control" />
                </div>
            </div>
            <?php if(null === $model->getId()) { ?>
                <div class="form-group col-md-12">
                    <div class="col-md-2">
                        <label for="password">Geslo</label>
                    </div>
                    <div class="col-md-10">
                        <input name="password" id="password" class="form-control" />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-2">
                        <label for="repeatPassword">Ponovi geslo</label>
                    </div>
                    <div class="col-md-10">
                        <input name="repeatPassword" id="repeatPassword" class="form-control" />
                    </div>
                </div>
            <?php } ?>
            <div class="form-group col-md-12">
                <div class="col-md-2">
                    <label for="type">Tip</label>
                </div>
                <div class="col-md-10">
                    <select class="form-control" id="userRoles" name="userRoles[]" multiple>
                        @foreach($userRoles as $item)
                            <option value="{{ $item->getId() }}" <?php if ($model->isInRole($item->getId())) echo 'selected'; ?>>
                                {{ $item->getLabel() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-offset-2">
                    <div class="input-group">
                        <input type="submit" class="btn btn-success" value="Shrani" />
                        <?php if(null !== $model->getId()) { ?>
                            <a href="#" onclick="warnDeleteStream()" class="btn btn-warning">Izbriši</a>
                        <?php } ?>
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