@section('title', 'Register - ' . config('app.name'))

<x-guest-layout>

    <div class="relative flex flex-col rounded-xl bg-transparent">
  <h4 class="block text-xl text-center font-medium text-blue-800">
    Register
  </h4>
  
  <form method="POST" action="{{ route('register') }}" class="mt-8 mb-2 w-80 max-w-screen-lg sm:w-96">
    @csrf
    <div class="mb-1 flex flex-col gap-6">
      <div class="w-full max-w-sm min-w-[200px]">
  <input 
    type="text" 
    name="name"
    placeholder="Your Name"
    class="w-full text-gray-900 placeholder:text-gray-400 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease-in-out focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
  />
</div>

      <div class="w-full max-w-sm min-w-[200px]">
        
        <input type="email" class="w-full placeholder:text-slate-400 text-gray-900 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Your Email" name="email" />
      </div>
      <div class="w-full max-w-sm min-w-[200px] relative">
        
    <input 
      id="password"
      type="password" 
      name="password"
      placeholder="Your Password"
      class="w-full placeholder:text-slate-400 text-gray-900 text-sm border border-slate-200 rounded-md px-3 py-2 pr-10 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
    />

        <!-- Eye icon -->
        <button type="button" 
                onclick="togglePasswordVisibility()" 
        class="absolute top-0 right-2 flex items-center justify-center p-2 text-gray-900 hover:text-slate-700 focus:outline-none">
              <!-- Closed eye (hidden state) -->
            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-3-10-7 1.125-3.75 5-7 10-7 1.125 0 2.25.15 3.25.425M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 3l18 18" />
            </svg>

            <!-- Open eye (visible state) -->
            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
      </div>
      <div class="w-full max-w-sm min-w-[200px] relative">
        
        <input 
            id="password_confirmation"
            type="password" 
            name="password_confirmation"
            placeholder="Confirm Password"
            class="w-full placeholder:text-slate-400 text-gray-900 text-sm border border-slate-200 rounded-md px-3 py-2 pr-10 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
        />

        
      </div>
    </div>
    
    <button class="mt-4 w-full rounded-md py-2 px-4 border border-transparent text-center text-md text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="submit" style="background-color: blue;">
      Sign Up
    </button>
    <p class="flex justify-center mt-6 text-sm text-slate-100">
      Already have an account?
      <a href="{{ route('login') }}" class="ml-1 text-sm font-semibold text-slate-700 underline">
        Login
      </a>
    </p>
    <a
        class="flex items-center justify-center mt-4 w-full rounded-md py-2 px-4 border border-transparent text-center text-md transition-all shadow-md hover:shadow-lg focus:bg-slate-100 focus:shadow-none active:bg-slate-700 hover:bg-slate-800 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
        type="button" href="{{ route('auth.google') }}"
    >
        <img src="{{ asset('assets/img/google.png') }}" alt="Google" class="w-6 h-6 mr-4">

        Sign Up with Google
    </a>
    <a
        class="flex items-center justify-center mt-4 w-full rounded-md py-2 px-4 border border-transparent text-center text-md transition-all shadow-md hover:shadow-lg focus:bg-slate-100 focus:shadow-none active:bg-slate-700 hover:bg-slate-800 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
        type="button" href=""
    >
        <img src="{{ asset('assets/img/facebook.png') }}" alt="Facebook" class="w-6 h-6 mr-4">

        Sign Up with Facebook
    </a>
   
  </form>
    </div>

</x-guest-layout>
<script>
    function togglePasswordVisibility() {
        const fields = [
            document.getElementById('password'),
            document.getElementById('password_confirmation')
        ];
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        const show = fields[0].type === 'password';
        fields.forEach(input => input.type = show ? 'text' : 'password');

        eyeOpen.classList.toggle('hidden', !show);
        eyeClosed.classList.toggle('hidden', show);
    }
</script>