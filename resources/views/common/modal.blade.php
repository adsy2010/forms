<div id="{{ $modalname }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $modaltitle }}</h4>
            </div>
            <div class="modal-body">
                {{ $modalcontent }}
            </div>
            <div class="modal-footer">
                {{ $modalsubmit }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
