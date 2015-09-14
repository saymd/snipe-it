@if ($errors->any())
<div class="col-md-12">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle"></i>
        <strong>@lang('notification.error'): </strong>
         @lang('notification.check_errors')
    </div>
</div>

@endif

@if ($message = Session::get('success'))
<div class="col-md-12">
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-check"></i>
        <strong>@lang('notification.success'): </strong>
        {{ $message }}
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="col-md-12">
    <div class="alert alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle"></i>
        <strong>@lang('notification.error'): </strong>
        {{ $message }}
    </div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="col-md-12">
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-warning"></i>
        <strong>@lang('notification.warning'): </strong>
        {{ $message }}
    </div>
</div>
@endif

@if ($message = Session::get('info'))
<div class="col-md-12">
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-info-circle"></i>
        <strong>@lang('notification.info'): </strong>
        {{ $message }}
    </div>
</div>
@endif
