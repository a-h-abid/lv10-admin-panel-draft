<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="{{ $defaultColorScheme == 'dark' ? 'dark' : '' }}">
<head>
  @include('_layout/_head')
</head>
<body class="bg-gray-50 dark:bg-gray-800">
  <nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        @component('_layout/components/header')
        @endcomponent
      </div>
    </div>
  </nav>

  <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
    @component('_layout/components/nav')
    @endcomponent

    <div id="sidebarBackdrop" class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90"></div>

    <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
      <main>
        <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
          <div class="mb-4 col-span-full xl:mb-2">
            @component('_layout/components/breadcrumb')
            @endcomponent

            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
              @yield('page-title')
            </h1>
          </div>

          @yield('contents')
        </div>
      </main>

      @component('_layout/components/footer')
      @endcomponent
    </div>
  </div>
</body>
</html>
