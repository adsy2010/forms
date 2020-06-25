
{{ (file_exists(storage_path("app/public/images/staff/".strtoupper(Auth::user()->uid).".jpg"))) ? 'yes' : 'no'  }}
{{ (in_array('Domain Users', json_decode(Auth::user()->groupmemberships->pluck('groupInfo')->pluck('name'), TRUE))) ? 'yes' : 'no' }}

@if(Authorisation::isInGroup('Domain Admins'))
yes
@endif
{{ $period = \Carbon\Carbon::now()->isoFormat('YMM') }}