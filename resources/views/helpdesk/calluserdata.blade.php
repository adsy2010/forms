<img style="max-height: 100px; width: auto;" class="hidden-sm hidden-xs img-circle" src="{{ ($callinfo->loggedBy == $callinfo->loggedFor) ? file_exists("images/staff/".strtoupper($callinfo->loggedByUser->uid).".jpg") ? "/images/staff/{$callinfo->loggedByUser->uid}.jpg" : '/images/staff/placeholder.png' : file_exists("images/staff/".strtoupper($callinfo->loggedByUser->uid).".jpg") ? "/images/staff/{$callinfo->loggedForUser->uid}.jpg" : '/images/staff/placeholder.png'  }}" alt="...">
<br>
<h4>
    {{ ($callinfo->loggedBy != $callinfo->loggedFor) ? $callinfo->loggedForUser->uid : $callinfo->loggedByUser->uid }}
</h4>
<hr class="hidden-xs hidden-sm">
<table class="table table-condensed small" style="">
    <tr>
        <th style="border: 0; padding: 0;">Logged By: </th>
        <td style="border: 0; padding: 0; display: block;">{{ $callinfo->loggedByUser->FirstName}} {{ $callinfo->loggedByUser->LastName}}</td>
    </tr>
    @if($callinfo->loggedBy != $callinfo->loggedFor)
        <tr>
            <th style="border: 0; padding: 0;">Logged For: </th>
            <td style="border: 0; padding: 0; display: block;">{{ $callinfo->loggedForUser->FirstName}} {{ $callinfo->loggedForUser->LastName}}</td>
        </tr>
    @endif
    <tr>
        <th style="border: 0; padding: 0;">Assigned to: </th>
        <td style="border: 0; padding: 0; display: block;">None</td>
    </tr>
</table>