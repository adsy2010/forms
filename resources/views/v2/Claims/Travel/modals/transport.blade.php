<!-- Modal -->
<div id="transportModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a transport item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="well">Please use the help buttons if you are not sure what to enter in any of the boxes.</div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Date</div>
                    <div class="col-md-6"><input class="form-control" type="date"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Date" data-content="The date that the transportation was used"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Transport</div>
                    <div class="col-md-6"><select class="form-control"><option disabled>none</option></select></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Transport type" data-content="The type of transport used"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Amount</div>
                    <div class="col-md-6"><input class="form-control" type="number"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Amount" data-content="The total cost of transport for this entry"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Add item</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>