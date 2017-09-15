@extends('dialogs.base', ['config' => ['id' => 'addEditStream', 'title' => 'Add/edit stream']])

@section('body')
    <div class="form-group row">
        <div class="col-md-2">
            <label>Tip</label>
        </div>
        <div class="col-md-10">
            <select class="form-control" name="type">
                @foreach($streamTypes as $item)
                    <option value="{{$item->getId()}}">{{$item->getLabel()}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2">
            <label>Naziv</label>
        </div>
        <div class="col-md-10">
            <input type="text" name="name" class="form-control" />
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2">
            <label>Ključ</label>
        </div>
        <div class="col-md-10">
            <input type="text" name="streamKey" class="form-control" />
        </div>
    </div>
@endsection

@section('footer')
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zapri</button>
    <button type="button" class="btn btn-primary" onclick="addEditStream()">Ustvari</button>
@endsection

@section('scripts')
    <script>


        function addEditStream() {
            var url = '{{ route('addEditStream') }}';
            var options = {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: document.getElementsByName('name')[0].value,
                    streamKey: document.getElementsByName('streamKey')[0].value,
                    type: document.getElementsByName('type')[0].value
                },
                success: function (response) {

                },
                error: function (response) {

                }
            };
            $.ajax(url, options);
        }

    </script>
@endsection