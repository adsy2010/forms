@foreach($calls->helpdeskCalls->pluck('calls') as $call)
    @php($callinfo = $call[0])
    <div id="thread-{{ $callinfo->id }}" class="row" style=" background-color: rgba(173,216,230,0.51); border-radius: 3px; border: 1px solid #c2c2c2; margin: 5px; ">
        <a name="thread-{{ $callinfo->id }}"></a>
        <div class="col-md-2 text-center" style="height:100%; padding:10px; font-size: 12px; border-right: 1px solid #c2c2c2;">
            @include('helpdesk.calluserdata')
        </div>
        <div class="col-md-10" style="padding: 0; border-left: 1px solid #c2c2c2;">
            @include('helpdesk.calldata')

        </div>
    </div>
@endforeach