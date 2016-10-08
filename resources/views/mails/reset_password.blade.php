<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{trans('auth.reset_pass_subject', ['host' => request()->getHost()])}}</title>
    </head>
    <body>
        <h3>{{trans('auth.reset_pass_subject', ['host' => request()->getHost()])}}</h3>
        <p>{!! trans('auth.reset_pass_content', ['host' => request()->getHost(), 'route' => route('get_reset_pass', ['token' => $token])]); !!}</p>
    </body>
</html>
