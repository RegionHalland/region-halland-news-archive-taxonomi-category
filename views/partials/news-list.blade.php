@php($news = get_region_halland_news_archive_taxonomi_category_items(2))
@if(isset($news) && !empty($news))
	@foreach ($news as $myNews)
		<article class="py-4">
			<a href="{{ $myNews->url }}" title="" class="text-blue-dark hover:bg-yellow-light focus:bg-yellow-light mb-2 inline-block">
				<h2 class="text-xl sm:text-2xl leading-tight">{{ $myNews->post_title }}</h2>
			</a>
			<span class="text-base block text-grey-darkest mb-4">Publicerad: <time itemprop="datePublished" datetime="{{ $myNews->date }}">{{ $myNews->date }}</time></span>
			<p class="text-lg text-grey-darkest leading-tight mb-4">{!! html_entity_decode(wp_trim_words($myNews->post_content, 70, '...')) !!}</p>
			<?php var_dump($myNews->terms); ?>	
			@foreach($myNews->terms as $term)
				<a href="{{ $term['link'] }}" class="px-2 mr-2 mb-2 py-1 text-sm no-underline hover:underline focus:underline text-black bg-blue-light rounded-full inline-block">{{ $term['name'] }}</a>
			@endforeach
		</article>
	@endforeach
	@if(isset($news_category->name))
		<a href="{{ get_post_type_archive_link(get_post_type()) }}?{{'filter[category]=' .  $news_category->slug }}" class="inline-flex no-underline text-white bg-blue-dark px-6 mt-4 items-center justify-between py-4 text-lg rounded">
		{{ get_post_type_object(get_post_type())->labels->view_items }} 
		{{ $news_category ? 'inom ' . strtolower($news_category->name) : '' }}
		<svg class="h-4 w-4"><use xlink:href="#chevron-right" /></svg></a>
	@else
		<a href="{!! env('WP_HOME') !!}/nyheter/nyheter" class="inline-flex no-underline text-white bg-blue-dark px-6 mt-4 items-center justify-between py-4 text-lg rounded">Se alla nyheter<svg class="h-4 w-4"><use xlink:href="#chevron-right" /></svg></a>
	@endif
@endif