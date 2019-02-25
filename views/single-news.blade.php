@extends('layouts.app')

@section('content')
<div class="bg-white pt-16 pb-8">
	<div class="container mx-auto px-4">
		<div class="w-full mx-auto">
			<div class="flex flex-wrap -mx-4">
				<div class="w-full sm:w-full md:w-8/12 px-4">
					@while(have_posts()) @php(the_post())
						<article class="">
							<h1 class="mb-8">{{ get_the_title() }}</h1>
							<div class="article">
								<p>{{ the_content() }}</p>
							</div>
							@include('partials.author-info')
						</article>
					@endwhile
				</div>
				<div class="w-full sm:w-full md:w-4/12 px-4 mt-8 md:mt-0">
					<div class="sticky pin-t">
					@php($news = get_region_halland_news_archive_taxonomi_category_items())
						@if(isset($news) && !empty($news))
						<header class="relative pb-4 block mb-4">
							<span class="border-b-2 border-yellow text-2xl font-bold text-black pb-2 z-20 relative leading-none">Fler nyheter</span>
							<hr class="absolute pin-b pin-l w-full h-0 border-b-2 mb-1 border-yellow-light z-10">
						</header>
						<ol class="list-reset bg-yellow-light relative rounded border border-grey-lightest overflow-hidden">
							@foreach ($news as $myNews)
									<li class="px-4 py-4 border-grey-lightest truncate overflow-hidden relative">
										<div class="absolute bg-yellow pin-l pin-t h-full w-1"></div>
										<a class="text-black whitespace-no-wrap" href="{{ $myNews->url }}">{{ $myNews->post_title }}</a>
									</li>
							@endforeach
						</ol>
						<a href="{{ get_post_type_archive_link(get_post_type()) }}" class="inline-block no-underline text-white bg-blue-dark px-6 mt-4 flex items-center justify-between py-4 text-lg rounded">Se alla nyheter<svg class="h-4 w-4"><use xlink:href="#chevron-right" /></svg></a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
