<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" ">
                <div class="row">

                
                @foreach ($posts as $post)

                @if(auth()->check())
                @if (auth()->user()->subscribed('cashier') || auth()->user()->is_admin)
                <div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->description }}</p>
                        </div>
                    </div>
                </div>
                @else

                @if($post->post_type =='Premium')
                <div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h4>please Buy <a href="{{ route('plans') }}">subscription</a> for show this post
                            </h4>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->description }}</p>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @else
                <h3>need to <a href="{{ route('login') }}">Login</a> to show posts</h3>
                @endif

                @endforeach
            </div>
            </div>
        </div>
    </div>
</x-app-layout>