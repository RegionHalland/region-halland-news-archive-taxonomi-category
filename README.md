# Skapa nyhetsfunktion inklusive arkiv med filter

## Hur man använder Region Hallands plugin "region-halland-news-archive-taxonomi-category"

Nedan följer instruktioner hur du kan använda pluginet "region-halland-news-archive-taxonomi-category".


## Användningsområde

Denna plugin skapar posttyp "news" inkl. taxonomi och använder "archive.php" för att visa nyheterna
OBS! Om du även har installerat pluginen "https://github.com/RegionHalland/region-halland-use-taxonomy-category-on-page.git", dvs att kunna använda taxonomy category på sidor, så kan du även använda funktionen "get_region_halland_page_news_taxonomi_category()" som hämtar ut nyheter som matchar kategori-noder sidor/nyheter.


## Licensmodell

Denna plugin använder licensmodell GPL-3.0. Du kan läsa mer om denna licensmodell via den medföljande filen:
```sh
LICENSE (https://github.com/RegionHalland/region-halland-news-archive-taxonomi-category/blob/master/LICENSE)
```


## Installation och aktivering

```sh
A) Hämta pluginen via Git eller läs in det med Composer
B) Installera Region Hallands plugin i Wordpress plugin folder
C) Aktivera pluginet inifrån Wordpress admin
```


## Hämta hem pluginet via Git

```sh
git clone https://github.com/RegionHalland/region-halland-news-archive-taxonomi-category.git
```


## Läs in pluginen via composer

Dessa två delar behöver du lägga in i din composer-fil

Repositories = var pluginen är lagrad, i detta fall på github

```sh
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/RegionHalland/region-halland-news-archive-taxonomi-category.git"
  },
],
```
Require = anger vilken version av pluginen du vill använda, i detta fall version 1.0.0

OBS! Justera så att du hämtar aktuell version.

```sh
"require": {
  "regionhalland/region-halland-news-archive-taxonomi-category": "1.0.0"
},
```


## Hämta alla kategorier via "Blade" och visa på "archive.php"

```sh
@if(function_exists('get_region_halland_news_archive_taxonomi_category_categories'))
  @php($categories = get_region_halland_news_archive_taxonomi_category_categories('Visa alla nyheter'))
    <ul>
      @foreach($categories as $category)
        <li>
          <a href="{{ $category['link'] }}">{{ $category['name'] }}</a>
        </li>
      @endforeach
    </ul>
@endif
```


## Exempel på hur arrayen kan se ut

```sh
array (size=6)
  0 => 
    array (size=2)
      'name' => string 'Visa alla nyheter' (length=17)
      'link' => string 'http://exempel.se/nyheter/' (length=26)
  1 => 
    array (size=2)
      'name' => string 'Lorem ipsum' (length=11)
      'link' => string 'http://exempel.se/nyheter/?filter[category]=okategoriserat' (length=58)
  2 => 
    array (size=2)
      'name' => string 'Lorem ipsum mit' (length=15)
      'link' => string 'http://exempel.se/nyheter/?filter[category]=lorem-ipsum-mit' (length=61)
  3 => 
    array (size=2)
      'name' => string 'Alqura met balum' (length=16)
      'link' => string 'http://exempel.se/nyheter/?filter[category]=alqura-met-balum' (length=54)
```

## Visa alla poster via "Blade" inklusive alla kategorier

```sh
@if(function_exists('get_region_halland_news_archive_taxonomi_category_filter'))
  @php($myPosts = get_region_halland_news_archive_taxonomi_category_filter())
    @foreach($myPosts as $post)
      <a href="{{ $post['permalink'] }}">
        <h2>{{ $post['title'] }}</h2>
      </a>
      <p>{{ $post['ingress'] }}</p>
      <span>Publicerad: {{ $post['date'] }}</span>
      <p>{{ $post['content'] }}</p>
        @foreach($post['terms'] as $term)
          <a href="{{ $term['link'] }}">{{ $term['name'] }}</a>
        @endforeach
    @endforeach
@endif
```


## Exempel på hur arrayen kan se ut

```sh
array (size=2)
  0 => 
    array (size=5)
      'permalink' => string 'http://exempel.se/nyheter/lorem-ipsum/' (length=38)
      'title' => string 'Lorem ipsum' (length=11)
      'content' => string 'Vestibulum ante ipsum primis in faucibus' (length=40)
      'ingress' => string 'Lorem ipsum' (length=11)
      'date' => string '2018-10-01' (length=10)
      'terms' => 
        array (size=1)
          0 => 
            array (size=2)
              'name' => string 'In nisl neque' (length=10)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=in-nisl-neque' (length=57)
  1 => 
    array (size=5)
      'permalink' => string 'http://exempel.se/nyheter/ellentesque-habitant-morbi/' (length=52)
      'title' => string 'Ellentesque habitant morbi' (length=26)
      'content' => string 'Donec maximus purus justo' (length=25)
      'ingress' => string 'Lorem ipsum' (length=11)
      'date' => string '2018-09-24' (length=10)
      'terms' => 
        array (size=2)
          0 => 
            array (size=2)
              'name' => string 'Morbi id eleifend' (length=17)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=morbi-id-eleifend' (length=61)
          1 => 
            array (size=2)
              'name' => string 'Donec eros diam' (length=15)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=donec-eros-diam' (length=59)
```


## Visa poster via "Blade" inklusive alla kategorier på valfri sida, i exemplet 2 poster

```sh
@if(function_exists('get_region_halland_news_archive_taxonomi_category_items'))
@php($news = get_region_halland_news_archive_taxonomi_category_items(2))
  @if(isset($news) && !empty($news))
    @foreach ($news as $myNews)
      <a href="{{ $myNews->url }}">
        <h2>{{ $myNews->post_title }}</h2>
      </a>
      <p>{{ $myNews->ingress }}</p>
      <span>Publicerad: {{ $myNews->date }}</span>
      <p>{!! $myNews->post_content !!}</p>
      @foreach($myNews->terms as $term)
        <a href="{{ $term['link'] }}">{{ $term['name'] }}</a>
      @endforeach
    @endforeach
  @endif
@endif
```

## Exempel på hur arrayen kan se ut

```sh
array (size=2)
  0 => 
    object(WP_Post)[8604]
      public 'ID' => int 6978
      public 'post_author' => string '174' (length=3)
      public 'post_date' => string '2018-11-20 10:06:18' (length=19)
      public 'post_date_gmt' => string '2018-11-20 08:06:18' (length=19)
      public 'post_content' => string 'Lorem ipsum' (length=11)
      public 'post_title' => string 'Lorem ipsum dolares' (length=19)
      public 'post_excerpt' => string '' (length=0)
      public 'post_status' => string 'publish' (length=7)
      public 'comment_status' => string 'closed' (length=6)
      public 'ping_status' => string 'closed' (length=6)
      public 'post_password' => string '' (length=0)
      public 'post_name' => string 'lorem-ipsum-dolares' (length=19)
      public 'to_ping' => string '' (length=0)
      public 'pinged' => string '' (length=0)
      public 'post_modified' => string '2018-11-20 10:06:53' (length=19)
      public 'post_modified_gmt' => string '2018-11-20 08:06:53' (length=19)
      public 'post_content_filtered' => string '' (length=0)
      public 'post_parent' => int 0
      public 'guid' => string 'http://exempel.se/?post_type=news&#038;p=6978' (length=45)
      public 'menu_order' => int 0
      public 'post_type' => string 'news' (length=4)
      public 'post_mime_type' => string '' (length=0)
      public 'comment_count' => string '0' (length=1)
      public 'filter' => string 'raw' (length=3)
      public 'url' => string 'http://exempel.se/lorem-ipsum-dolares/' (length=38)
      public 'image' => string '' (length=0)
      public 'image_url' => boolean false
      public 'date' => string '2018-11-20' (length=10)
      public 'ingress' => string 'Lorem ipsum' (length=11)
      public 'terms' => 
        array (size=1)
          0 => 
            array (size=3)
              'name' => string 'Quertum alares' (length=14)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=quertum-alares' (length=34)
  1 => 
    object(WP_Post)[8606]
      public 'ID' => int 6966
      public 'post_author' => string '174' (length=3)
      public 'post_date' => string '2018-11-19 14:15:49' (length=19)
      public 'post_date_gmt' => string '2018-11-19 12:15:49' (length=19)
      public 'post_content' => string 'Vestibulum semper rhoncus' (length=25)
      public 'post_title' => string 'Phasellus tristique dignissim' (length=28)
      public 'post_excerpt' => string '' (length=0)
      public 'post_status' => string 'publish' (length=7)
      public 'comment_status' => string 'closed' (length=6)
      public 'ping_status' => string 'closed' (length=6)
      public 'post_password' => string '' (length=0)
      public 'post_name' => string 'phasellus-tristique-dignissim' (length=28)
      public 'to_ping' => string '' (length=0)
      public 'pinged' => string '' (length=0)
      public 'post_modified' => string '2018-11-19 14:17:09' (length=19)
      public 'post_modified_gmt' => string '2018-11-19 12:17:09' (length=19)
      public 'post_content_filtered' => string '' (length=0)
      public 'post_parent' => int 0
      public 'guid' => string 'http://exempel.se/?post_type=news&#038;p=6966' (length=42)
      public 'menu_order' => int 0
      public 'post_type' => string 'news' (length=4)
      public 'post_mime_type' => string '' (length=0)
      public 'comment_count' => string '0' (length=1)
      public 'filter' => string 'raw' (length=3)
      public 'url' => string 'http://exempel.se/nyheter/phasellus-tristique-dignissim/' (length=55)
      public 'image' => string '' (length=0)
      public 'image_url' => boolean false
      public 'date' => string '2018-11-19' (length=10)
      public 'ingress' => string 'Lorem ipsum' (length=11)
      public 'terms' => 
        array (size=1)
          0 => 
            array (size=3)
              'name' => string 'Marumel domir' (length=13)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=marumelddomir' (length=58)
```


## Visa poster via "Blade" inklusive alla kategorier på på relaterad sida/nyhet.

```sh
@if(function_exists('get_region_halland_page_news_taxonomi_category'))
@php($pageNews = get_region_halland_page_news_taxonomi_category())
  @if(isset($pageNews) && !empty($pageNews))
    @foreach ($pageNews as $myNews)
      <a href="{{ $myNews['permalink'] }}">
        <h2>{{ $myNews['title'] }}</h2>
      </a>
      <p>{{ $myNews['ingress'] }}</p>
      <span>Publicerad: {{ $myNews['date'] }}</span>
      <p>{!! $myNews['content'] !!}</p>
      @foreach($myNews['terms'] as $term)
        <a href="{{ $term['link'] }}">{{ $term['name'] }}</a>
      @endforeach
    @endforeach
  @endif
@endif
```


## Exempel på hur arrayen kan se ut

```sh
array (size=2)
  0 => 
    array (size=8)
      'ID' => string '102' (length=3)
      'title' => string 'Lorem ipsum' (length=11)
      'permalink' => string 'http://exempel.se/nyheter/lorem-ipsum/' (length=38)
      'date' => string '2019-02-11' (length=10)
      'content' => string 'Vestibulum ante ipsum primis in faucibus' (length=40)
      'ingress' => string 'Lorem ipsum' (length=11)
      'image' => string '' (length=0)
      'image_url' => boolean false
      'terms' => 
        array (size=2)
          0 => 
            array (size=2)
              'name' => string 'Morbi id eleifend' (length=17)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=morbi-id-eleifend' (length=61)
  1 => 
    array (size=8)
      'ID' => string '124' (length=3)
      'title' => string 'Ellentesque habitant morbi' (length=26)
      'permalink' => string 'http://exempel.se/nyheter/ellentesque-habitant-morbi/' (length=52)
      'date' => string '2019-03-05' (length=10)
      'content' => string 'Donec maximus purus justo' (length=25)
      'image' => string '' (length=0)
      'image_url' => boolean false
      'terms' => 
        array (size=2)
          0 => 
            array (size=2)
              'name' => string 'Morbi id eleifend' (length=17)
              'link' => string 'http://exempel.se/nyheter/?filter[category]=morbi-id-eleifend' (length=61)
```


## Visa ingressen på en single-sida via "Blade"

```sh
<p>{{ get_region_halland_page_news_taxonomi_category_ingress() }}</p>
```


## Versionhistorik

### 1.4.0
- Uppdaterat med information om licensmodell
- Bifogat fil med licensmodell

### 1.3.3
- Korrigerat bugg. Bara post_type 'news' ska hämtas ut för relaterade poster

### 1.3.2
- Hämtades bara ut 10 nyheter istället för alla.

### 1.3.1
- Justerat med ID för ingress

### 1.3.0
- Fält för ingress tillagd
- Funktion för att hämta ut ingress på en single-sida
- Fältet ingress tillagd i alla listuthämtningar
- Förändrad url i filterfunktion, från ?filter[category] till ?category

### 1.2.2
- Default antal nyheter på en sida är 4
- Möjlighet att själv välja antal nyheter på en sida
- Senast publicerad överst

### 1.2.1
- Förbättrad readme

### 1.2.0
- Lagt till funktion för relaterade sidor/nyheter

### 1.1.0
- Lagt till behörigheter

### 1.0.0
- Första version