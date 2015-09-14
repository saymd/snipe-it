@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.account') @lang('general.sign_in') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <h3>@lang('general.sign_in')</h3>
    </div>
</div>

<div class="col-md-11 col-md-offset-1">

    <form method="post" action="{{ route('signin') }}" class="form-horizontal">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- username -->
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="username" class="col-md-2 col-sm-12 control-label">@lang('admin/users/table.username')</label>
                    <div class="col-md-5 col-sm-12">
                        <input class="form-control" type="username" name="username" id="username" value="{{{ Input::old('username') }}}" />
                        {{ $errors->first('username', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Password -->
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-2 col-sm-12 control-label">@lang('admin/users/table.password')</label>
                    <div class="col-md-5 col-sm-12">
                        <input class="form-control" type="password" name="password" id="password" value="{{{ Input::old('password') }}}" />
                        {{ $errors->first('password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Form Actions -->
            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-2">

                <div class="col-md-3 col-sm-12 col-xs-12" style="padding-left: 0px;">
                    <div class="checkbox">
                        <label>
                          {{ Form::checkbox('remember-me', '1', Input::old('remember-me')) }} @lang('auth/general.remember_me')
                        </label>
                    </div>
                </div>

	    		<div class="col-md-2 col-sm-12 col-xs-12 text-right">
	                 <button type="submit" class="btn btn-success">@lang('general.sign_in')</button>
	            </div>
            </div>

    </form>
</div>

<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-2 text-right" style="padding-top: 40px; padding-right: 60px">
      <a href="{{ route('forgot-password') }}">@lang('auth/general.forgot_my_password')</a>
</div>

@stop
