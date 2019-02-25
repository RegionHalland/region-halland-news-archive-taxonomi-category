<article class="py-4">
	<a href="{{ $post['permalink'] }}" title="" class="text-blue-dark hover:bg-yellow-light focus:bg-yellow-light mb-2 inline-block">
		<h2 class="text-xl sm:text-2xl leading-tight">{{ $post['title'] }}</h2>
	</a>
	<span class="text-base block text-grey-darkest mb-4">Publicerad: <time itemprop="datePublished" datetime="{{ $post['date'] }}">{{ $post['date'] }}</time></span>
	<p class="text-lg text-grey-darkest leading-tight mb-4">{{ html_entity_decode(wp_trim_words($post['content'], 60, '...')) }}</p>
	<?php var_dump($post['terms']); ?>
		@foreach($post['terms'] as $term)
			<a href="{{ $term['link'] }}" class="px-2 mr-2 mb-2 py-1 text-sm no-underline hover:underline focus:underline text-black bg-blue-light rounded-full inline-block">{{ $term['name'] }}</a>
		@endforeach
	
</article>