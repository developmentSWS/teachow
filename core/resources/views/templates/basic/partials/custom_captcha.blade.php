@php $captcha = loadCustomCaptcha($general->base_color) @endphp
@if($captcha)
    <div class="form-group ">
        <label>@lang('Captcha Code')</label>
        @php echo $captcha @endphp
    </div>
    <div class="form-group">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control">
    </div>
@endif
