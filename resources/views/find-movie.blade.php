<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head> @include('components.head') </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <div class="width-4 mx-auto p-6 lg:p-8">

                <h1 class="dark:text-white" style="text-align: center; font-size: xx-large; ">Try a search... or try your luck!</h1>
                <div class="flex justify-center">
                    <form class="mt-6" method="POST" action="/find-movie">
                        @csrf
                        <label for="title"></label>
                        <input style="    padding: 5px;" type="text" id="title" name="title" class="form-control" required="">
                        @component('components.submit') Lookup Movie @endcomponent


                    </form>
                </div>

                <div class="mt-16" style="width: 75%; margin: 4rem auto;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 2">

                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                @empty($data)
                                    <h1 class=" text-xl font-semibold text-gray-900 dark:text-white">Try another search?</h1>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 2">
                                        <div class="mt-6">
                                            <h1 class=" text-xl font-semibold text-gray-900 dark:text-white"> {{$data->title}}</h1>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{$data->year}}</p>
                                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{$data->plot}}</p>
                                        </div>
                                        <div class="mt-6">
                                        @component('components.metascore') {{$data->metascore}} @endcomponent
                                        <img src="{{$data->poster}}">
                                            <p class="{{$data->rated}} mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">  {{$data->rated}} </p>
                                    </div>
                                    </div>
                                @endempty
                            </div>
                        </div>

                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none  motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            @isset($lucky)

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 2">
                                    <div class="mt-6">
                                        <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white"> Why not try ...?</h1>

                                        <h1 class=" text-xl font-semibold text-gray-900 dark:text-white"> {{ $lucky['title'] }}</h1>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{$lucky['year']}} </p>
                                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{$lucky['plot'] }}</p>
                                        <form method="POST" action="/lucky" style="margin-top: 15px;">
                                            @csrf
                                            @component('components.submit') #Shuffle @endcomponent
                                        </form>
                                    </div>
                                    <div class="mt-6">
                                        @component('components.metascore') {{$lucky['metascore']}} @endcomponent
                                        <img src="{{$lucky['poster']}}">
                                        <p class="{{$lucky['rated']}} mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">  {{$lucky['rated']}} </p>

                                    </div>
                                </div>



                            @else
                                <h1 class=" text-xl font-semibold text-gray-900 dark:text-white">Feeling lucky?</h1>
                                <form method="POST" action="/lucky" style="margin-top: 15px;">
                                    @csrf
                                    @component('components.submit') #Shuffle @endcomponent
                                </form>
                            @endisset
                        </div>

                        </div>
                </div>
                @include('components.footer')


            </div>

        </div>
    </body>
</html>
