<div class="modal fade" id="{{$config['id']}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title col-md-10" id="exampleModalLabel">{{$config['title']}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @yield('body')
            </div>
            <div class="modal-footer">
                @yield('footer')
            </div>
        </div>
    </div>
</div>
@yield('scripts')