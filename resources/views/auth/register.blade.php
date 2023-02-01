<x-guest-layout>

    <div class="min-h-screen w-full grid md:grid-cols-2">
        <div class=" h-full flex justify-center items-center">
            <section class="text-gray-500 w-3/5 h-full py-11 flex flex-col justify-between">
                <main>
                    <header>
                        <h1 class="text-gray-800  text-2xl lg:text-3xl  font-semibold">Registrate en</h1>
                        <h2 class="text-blue-700 text-2xl lg:text-4xl font-bold">All in one</h2>
                    </header>

                    <form method="POST" action="{{ route('register') }}" class="mt-10">
                        <x-jet-validation-errors class="mb-4" />
                        @csrf

                        {{-- Name --}}
                        <div class="relative">
                            <input placeholder="Nombre del usuario" type="text"
                                class="pl-10 border-gray-300 focus:border-blue-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:text-gray-700 focus:font-semibold rounded-md shadow-sm block mt-1 w-full"
                                type="text" name="name" value="{{ old('name') }}" required autofocus
                                autocomplete="name">
                            <span
                                class="flex items-center absolute inset-y-0 left-0 ml-3 text-xl text-blue-600 leading-5">
                                <i class='bx bx-user-circle'></i>
                            </span>
                        </div>

                        {{-- Username --}}
                        <div class="relative mt-4">
                            <input placeholder="Username" type="text"
                                class="pl-10 border-gray-300 focus:border-blue-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:text-gray-700 focus:font-semibold rounded-md shadow-sm block mt-1 w-full"
                                type="text" name="username" value="{{ old('username') }}" required autofocus
                                autocomplete="username">
                            <span
                                class="flex items-center absolute inset-y-0 left-0 ml-3 text-xl text-blue-600 leading-5">
                                <i class='bx bx-rename'></i>
                            </span>
                        </div>

                        {{-- Email --}}
                        <div class="relative mt-4">
                            <input placeholder="Email" type="text"
                                class="pl-10 border-gray-300 focus:border-blue-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:text-gray-700 focus:font-semibold rounded-md shadow-sm block mt-1 w-full"
                                type="text" name="email" value="{{ old('email') }}" autofocus autocomplete="email">
                            <span
                                class="flex items-center absolute inset-y-0 left-0 ml-3 text-xl text-blue-600 leading-5">
                                <i class='bx bx-envelope'></i>
                            </span>
                        </div>

                        {{-- Contraseña --}}
                        <div class="relative mt-4" x-data="{ show: true }">
                            <input placeholder="Contraseña" :type="show ? 'password' : 'text'"
                                class="pl-10 border-gray-300 focus:border-blue-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:text-gray-700 focus:font-semibold rounded-md shadow-sm block mt-1 w-full"
                                name="password" required autocomplete="new-password">
                            <span
                                class="flex items-center absolute inset-y-0 left-0 ml-3 text-xl text-blue-600 leading-5">
                                <i class='bx bxs-lock-alt'></i>
                            </span>
                            <div class="flex items-center absolute inset-y-0 right-0 mr-3  text-sm leading-5">
                                <svg @click="show = !show" :class="{'hidden': !show, 'block':show }"
                                    class="h-4 text-blue-500" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 576 512">
                                    <path fill="currentColor"
                                        d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                    </path>
                                </svg>

                                <svg @click="show = !show" :class="{'block': !show, 'hidden':show }"
                                    class="h-4 text-blue-500" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 640 512">
                                    <path fill="currentColor"
                                        d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div class="relative mt-4" x-data="{ show: true }">
                            <input placeholder="Confirmar contraseña" :type="show ? 'password' : 'text'"
                                class="pl-10 border-gray-300 focus:border-blue-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:text-gray-700 focus:font-semibold rounded-md shadow-sm block mt-1 w-full"
                                name="password_confirmation" required autocomplete="new-password">
                            <span
                                class="flex items-center absolute inset-y-0 left-0 ml-3 text-xl text-blue-600 leading-5">
                                <i class='bx bxs-lock-alt'></i>
                            </span>
                        </div>


                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms" />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'"
                                            class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of
                                            Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'"
                                            class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy
                                            Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                        @endif

                        <div class="flex flex-col-reverse md:flex-row md:items-center md:justify-between mt-7">
                            <p class="text-sm text-gray-700 mt-3 md:mt-0">{{ __('¿Ya estás registrado?') }}
                                <a href="{{ route('login') }}" class="text-blue-700 font-semibold">Iniciar sesión</a>
                            </p>

                            <button type="submit"
                                class="md:ml-4 md:inline-flex md:items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                Registrar
                            </button>
                        </div>
                    </form>
                </main>

                <p class="text-sm text-gray-700 mt-3 md:mt-0">© 2020 Todos los derechos reservados. <a href="#"
                        class="text-blue-700 font-semibold">All in one</a> es un producto de milton.</p>
            </section>
        </div>

        {{-- Contenedor del logo --}}
        <div class="hidden md:flex justify-center items-center" style="background-color: #060818;">
            <div class="w-1/2 h-3/4 text-white">
                <img src="{{ asset('img/logo-white-background.svg') }}" alt="logo_milton" class="w-full h-full">
            </div>
        </div>
    </div>

</x-guest-layout>
