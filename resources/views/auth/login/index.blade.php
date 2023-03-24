@extends('_layout/guest')

@section('page-title', trans('auth.login-page.title'))

@section('contents')
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

    @component('auth/components/header')
    @endcomponent

    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <div class="flex justify-between">
          @component('auth/components/login-message')
          @endcomponent

          @component('_layout/components/theme-toggle')
          @endcomponent
        </div>

        @if (!empty($flash['error']))
          <div class="bg-red-500 text-grey-500 dark:bg-red-600 dark:text-gray-900 p-2 border-gray-300 dark:border-gray-600 rounded-lg">
            {{ $flash['error'] }}
          </div>
        @endif

        <form class="space-y-4 md:space-y-6" method="post" action="{{ route('abdadmin.login:post') }}">
          @csrf

          @component('auth/components/identity/' . $authConfig['identity'])
          @endcomponent

          @if (in_array('password', $authConfig['verification']) && $authConfig['flowType'] == 'regular')
            @component('auth/components/password')
            @endcomponent
          @endif

          <div class="flex items-center justify-between">
            @component('auth/components/remember-me')
            @endcomponent

            @component('auth/components/forgot-password')
            @endcomponent
          </div>

          @component('auth/components/submit-button')
            @if ($authConfig['flowType'] == 'stepped')
              @lang('auth.login-page.next-button')
            @else
              @lang('auth.login-page.login-button')
            @endif
          @endcomponent
        </form>
      </div>
    </div>

    @component('_layout/components/footer')
    @endcomponent
  </div>
@endsection
