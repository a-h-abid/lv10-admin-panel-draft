<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="{{ $defaultColorScheme == 'dark' ? 'dark' : '' }}">
<head>
  @include('_layout/_head')
</head>
<body>
  <section class="bg-gray-50 dark:bg-gray-900">
    @yield('contents')
  </section>
</body>
</html>
