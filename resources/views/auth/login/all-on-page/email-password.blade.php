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

          @component('auth/components/theme-toggle')
          @endcomponent
        </div>

        <form class="space-y-4 md:space-y-6"  method="post" action="{{ url('/') }}">
          @csrf

          @component('auth/components/identity/' . $identity)
          @endcomponent

          @component('auth/components/password')
          @endcomponent

          <div class="flex items-center justify-between">
            @component('auth/components/remember-me')
            @endcomponent

            @component('auth/components/forgot-password')
            @endcomponent
          </div>

          @component('auth/components/submit-button')
            @lang('auth.login-page.login-button')
          @endcomponent
        </form>
      </div>
    </div>

    @component('auth/components/footer')
    @endcomponent
  </div>
@endsection
