@if(Session::has('global'))
<div id="alertMsgs" class="alert alert-danger text-center infoMsg">{{ Session::get('global') }}</div>
@endif