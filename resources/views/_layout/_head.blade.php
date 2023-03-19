<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>{{ trans('_common.titlebar.base-title', [
  'pageTitle' => $__env->yieldContent('page-title', trans('_common.titlebar.untitled-title')),
  'separator' => config('layout.pipe-separator'),
  'appName' => config('app.name'),
]) }}</title>

@vite(['resources/css/app.css','resources/js/app.js'])
