<!-- Modal -->
<div id="mileageModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a mileage item</h4>
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
                        <a href='#' class="lead" data-toggle="popover" title="Date" data-content="The date of travel"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Time</div>
                    <div class="col-md-6"><input class="form-control" type="time"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Time" data-content="The time of travel"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Vehicle</div>
                    <div class="col-md-6"><input class="form-control" type="text"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Vehicle" data-content="The car registration"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Mileage type</div>
                    <div class="col-md-6"><select class="form-control"><option disabled>none</option></select></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Mileage Type" data-content="Business or training mileage"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">From</div>
                    <div class="col-md-6"><input class="form-control" type="text"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="From" data-content="The origin of your journey"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">To</div>
                    <div class="col-md-6"><input class="form-control" type="text"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="To" data-content="The destination of your journey"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Reason</div>
                    <div class="col-md-6"><input class="form-control" type="text"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Reason" data-content="The reason for this mileage claim"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">Mileage</div>
                    <div class="col-md-6"><input min="0" inputmode="numeric" pattern="[0-9]*" class="form-control" type="number"></div>
                    <div class="col-md-1 pull-right">
                        <a href='#' class="lead" data-toggle="popover" title="Mileage" data-content="The total mileage of this entry"><span class="fa fa-question-circle"></span></a>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add item</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>