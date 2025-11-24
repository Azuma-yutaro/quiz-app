<x-play-layout>
<section class="text-gray-600 body-font relative">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-12">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $category->name }}</h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $category->description }}</p>
    </div>


    @if($quizzesCount > 0 )
    <div class="lg:w-1/2 md:w-2/3 mx-auto">

        <div class="p-2 w-full">
          <button
        onclick="location.href='{{ route('categories.quizzes',['categoryId' => $category->id]) }}'"
          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Start</button>
        </div>

    </div>
    @else
      <h1 class="text-center sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Coming Soon...</h1>

    @endif

  </div>
</section>
</x-play-layout>
