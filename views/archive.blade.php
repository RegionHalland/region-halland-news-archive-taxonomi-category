@extends('layouts.app')

@section('content')

<main class="bg-white pt-12 pb-8" id="main">
	<div class="container mx-auto px-4">
		<div class="w-full mx-auto">
			<div class="flex flex-wrap -mx-4">
				<div class="w-full md:w-8/12 px-4">
					<header class="relative pb-4 block">
						<h1 class="inline-block border-b-2 border-blue-dark text-2xl font-bold text-black pb-2 z-20 relative leading-none">{{ get_the_archive_title() }}</h1>
						<hr class="absolute pin-b pin-l w-full h-0 border-b-2 mb-4 border-blue-light z-10">
					</header>
					@php($myPosts = get_region_halland_news_archive_taxonomi_category_filter())
					@foreach($myPosts as $post)
						@include('partials.news-list-item')
					@endforeach
				</div>
				<div class="w-full md:w-4/12 px-4 mt-12 md:mt-0">
					<header class="relative pb-4 block mb-8">
						<span class="border-b-2 border-blue-dark text-2xl font-bold text-black pb-2 z-20 relative leading-none">Filtrera på område</span>
						<hr class="absolute pin-b pin-l w-full h-0 border-b-2 mb-1 border-blue-light z-10">
					</header>
					@php($categories = get_region_halland_news_archive_taxonomi_category_categories('Visa alla nyheter'))
					<ul class="list-reset">
						@foreach($categories as $category)
							<li><a href="{{ $category['link'] }}" class="px-2 mb-2 py-1 text-sm no-underline hover:underline focus:underline text-black bg-grey-lightest rounded-full inline-block">{{ $category['name'] }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</main>

@endsection