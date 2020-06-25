<div style="color: whitesmoke; background-color: #244575; padding: 5px 15px 5px;" class="col-md-12">
    <strong>Logged at:</strong> {{ date(DATE_RFC2822, strtotime($callinfo->created_at)) }}<br>
    <strong>Location:</strong> {{ $callinfo->location }}
</div>

<div style="padding: 20px;" class="col-md-12">

    <div style="">{!! $callinfo->content !!}</div>
    @include('helpdesk.responsespart')
</div>