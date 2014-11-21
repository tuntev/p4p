@if(Session::has('success'))
<div class="alert alert-info alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      {{ Session::get('success') }}
</div>
{{--<div id="alertMsgs" class="alert alert-info text-center"></div>--}}
@endif