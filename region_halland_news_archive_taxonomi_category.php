<?php

	/**
	 * @package Region Halland News Archive Taxonomi Category
	 */
	/*
	Plugin Name: Region Halland News Archive Taxonomi Category
	Description: Skapa posttyp "news" inkl. taxonomi och använder "archive.php" för att visa nyheterna 
	Version: 1.0.0
	Author: Roland Hydén
	License: MIT
	Text Domain: regionhalland
	*/

	// vid 'init'
	add_action( 'init', 'region_halland_register_news_archive_taxonomi_category' );

	// Denna funktion registrerar en ny post_type och gör den synlig i wp-admin
	function region_halland_register_news_archive_taxonomi_category() {
		
		// Vilka labels denna post_type ska ha
		$labels = array(
		       'name' => _x('Nyheter', 'post type general name', 'halland' ),
				'singular_name' => _x('Nyhet', 'post type singular name', 'halland' ),
				'menu_name' => _x('Nyheter', 'admin menu', 'halland' ),
				'view_items' => _x('Se alla nyheter', 'halland' )
		    );
		
		// Inställningar för denna post_type 
	    $args = array(
	        'labels' => $labels,
	        'rewrite' => array('slug' => 'nyheter'),
			'has_archive' => true,
			'public' => true,
			'taxonomies' => array('category'),
	    );

	    // Registrera post_type
	    register_post_type('news', $args);
	    
	}

	function get_region_halland_news_archive_taxonomi_category_filter() {
		
		// Wordpress funktion för aktuell post
		global $post;
		
		// Ta emot valt filter
		$args = array();
		if(isset($_GET["filter"]["category"])){
			$strCategoryName = $_GET["filter"]["category"];
			$args = array(
				'category_name' => $strCategoryName
			);
		}
		$args = array_merge(array('post_type' => $post->post_type), $args);

		// Hämta valda poster
		$posts = new \WP_Query($args);
		
		// Temporär arrat
		$myPosts = array();
		
		// Loopa igenom alla poster
		while ($posts->have_posts()) { 
			
			// Temporär array
			$myTerms = array();
			
			// Sätt variabler
			$posts->the_post();
			$strPermalink = get_permalink();
	        $strTitle = $post->post_title;
	        $dtmDate = get_the_date('Y-m-d', $post->ID);
	        $strContent = $post->post_content;
	        
	        // Hämta alla kategorier för en post och pusha dessa till $myTerms
	        if (get_the_terms($post->ID, 'category')){
	     		foreach (get_the_terms($post->ID, 'category') as $key => $term) {
	     			$termName = $term->name;
	     			$termSlug = $term->slug;
			        array_push($myTerms, array(
			           'name' => $termName,
			           'link' => get_post_type_archive_link(get_post_type()) . "?filter[category]=" . $termSlug
			        ));
	     		}
	        }
	        
	        // Pusha alla variabler till $myPosts
	        array_push($myPosts, array(
	           'permalink' => $strPermalink,
	           'title' => $strTitle,
	           'content' => $strContent,
	           'date' => $dtmDate,
	           'terms' => $myTerms
	        ));
		
		}
	    
	    // Returnera arrayen med poster
	    return $myPosts;
	}

	// Hämta alla kaetgorier, valfritt om alla ska visas
	function get_region_halland_news_archive_taxonomi_category_categories($showText = null) {
		
		// Hämta alla kategorier
		$terms = get_terms('category');

		// Temporär array
        $myTerms = array();
		
		// Om man vill visa alla nyheter
		if ($showText) {
    		$strTermName = $showText;
	        $strTermSlug = "";
	    	array_push($myTerms, array(
	           'name' => $strTermName,
	           'link' => get_post_type_archive_link(get_post_type()) . $strTermSlug
	        ));
		}

		// Skapa array med länkar
        foreach ($terms as $term) {
	        $strTermName = $term->name;
	        $strTermSlug = $term->slug;
	        array_push($myTerms, array(
	           'name' => $strTermName,
	           'link' => get_post_type_archive_link(get_post_type()) . "?filter[category]=" . $strTermSlug
	        ));
        }

        // Returnera array med alla kategorier
		return $myTerms;
	}

	// OLD NAME = get_region_halland_vg_news
	function get_region_halland_news_archive_taxonomi_category_items($myAntal = 3) {
		
		// Preparerar array för att hämta ut nyheter
		$args = array( 
			'post_type' => 'news',
			'posts_per_page' => $myAntal,
		);

		// Hämta valda nyheter
		$myPages = get_posts($args);
		
		foreach ($myPages as $page) {

			// Lägg till sidans url 	
			$page->url = get_page_link($page->ID);

			// Bild
			$page->image = get_the_post_thumbnail($page->ID);
			$page->image_url = get_the_post_thumbnail_url($page->ID);
			
			// Publicerad datum
			$page->date = get_the_date('Y-m-d', $page->ID);
	        
	        // Hämta alla taxonimi-filter
			$page->terms = get_region_halland_news_archive_taxonomi_category_terms($page->ID);
		}
		
		// Returnera object med all poster
		return $myPages;

	}

	// Hämta alla kategorier för en post
	function get_region_halland_news_archive_taxonomi_category_terms($ID) {

		// Temporär array
		$myTerms = array();

		// Loopa igenom alla kategorier för posten
	    if (get_the_terms($ID, 'category')){
     		foreach (get_the_terms($ID, 'category') as $key => $term) {
     			$termName = $term->name;
     			$termSlug = $term->slug;
		        array_push($myTerms, array(
		           'name' => $termName,
		           'link' => get_post_type_archive_link(get_post_type($ID)) . "?filter[category]=" . $termSlug
		        ));
     		}
        }

        // Returnera arrayen med alla kategorier
        return $myTerms;
	    
	}

	// Metod som anropas när pluginen aktiveras
	function region_halland_register_news_archive_taxonomi_category_activate() {
		
		// Vi aktivering, registrera post_type "news"
		region_halland_register_news_archive_taxonomi_category();

		// Tala om för wordpress att denna post_type finns
		// Detta gör att permalink fungerar
	    flush_rewrite_rules();
	}

	// Metod som anropas när pluginen avaktiveras
	function region_halland_register_news_archive_taxonomi_category_deactivate() {
		// Ingenting just nu...
	}
	
	// Vilken metod som ska anropas när pluginen aktiveras
	register_activation_hook( __FILE__, 'region_halland_register_news_archive_taxonomi_category_activate');

	// Vilken metod som ska anropas när pluginen avaktiveras
	register_deactivation_hook( __FILE__, 'region_halland_register_news_archive_taxonomi_category_deactivate');

?>