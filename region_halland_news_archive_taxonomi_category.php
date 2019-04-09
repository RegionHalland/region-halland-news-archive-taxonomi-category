<?php

	/**
	 * @package Region Halland News Archive Taxonomi Category
	 */
	/*
	Plugin Name: Region Halland News Archive Taxonomi Category
	Description: Skapa posttyp "news" inkl. taxonomi och använder "archive.php" för att visa nyheterna 
	Version: 1.3.0
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
			'capabilities' => array(
			  'edit_post'          => 'edit_news', 
			  'read_post'          => 'read_news', 
			  'delete_post'        => 'delete_news', 
			  'edit_posts'         => 'edit_news', 
			  'edit_others_posts'  => 'edit_others_news', 
			  'publish_posts'      => 'publish_news',       
			  'read_private_posts' => 'read_private_news', 
			  'create_posts'       => 'edit_news', 
			),
	    );

	    // Registrera post_type
	    register_post_type('news', $args);
	    
	}

	// Anropa function om ACF är installerad
	add_action('acf/init', 'my_acf_add_news_ingress_field_groups');

	// Function för att lägga till "field groups"
	function my_acf_add_news_ingress_field_groups() {

		if (function_exists('acf_add_local_field_group')):

			acf_add_local_field_group(array(
			    'key' => 'group_1000140',
			    'title' => 'Nyhetsingress',
			    'fields' => array(
			        0 => array(
			        	'key' => 'field_1000141',
			            'label' => __('Ingress', 'regionhalland'),
			            'name' => 'name_1000142',
			            'type' => 'textarea',
			            'instructions' => __('Skriv din ingress här', 'regionhalland'),
			            'required' => 0,
			            'conditional_logic' => 0,
			            'wrapper' => array(
			                'width' => '',
			                'class' => '',
			                'id' => '',
			            ),
			            'default_value' => '',
			            'placeholder' => '',
			            'prepend' => '',
			            'append' => '',
			            'maxlength' => '',
			        ),
			    ),
			    'location' => array(
			        0 => array(
			            0 => array(
			                'param' => 'post_type',
			                'operator' => '==',
			                'value' => 'news',
			            ),
			        )
			    ),
			    'menu_order' => 0,
			    'position' => 'normal',
			    'style' => 'default',
			    'label_placement' => 'top',
			    'instruction_placement' => 'label',
			    'hide_on_screen' => '',
			    'active' => 1,
			    'description' => '',
			));

		endif;
	
	}

	function get_region_halland_news_archive_taxonomi_category_filter() {
		
		// Wordpress funktion för aktuell post
		global $post;
		
		// Ta emot valt filter
		$args = array();
		if(isset($_GET["category"])){
			$strCategoryName = $_GET["category"];
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
	    	$strIngress = get_field('name_1000142', $post->ID);
    
	        // Hämta alla kategorier för en post och pusha dessa till $myTerms
	        if (get_the_terms($post->ID, 'category')){
	     		foreach (get_the_terms($post->ID, 'category') as $key => $term) {
	     			$termName = $term->name;
	     			$termSlug = $term->slug;
			        array_push($myTerms, array(
			           'name' => $termName,
			           'link' => get_post_type_archive_link(get_post_type()) . "?category=" . $termSlug
			        ));
	     		}
	        }
	        
	        // Pusha alla variabler till $myPosts
	        array_push($myPosts, array(
	           'permalink' => $strPermalink,
	           'title' => $strTitle,
	           'content' => $strContent,
	           'ingress' => $strIngress,
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
	           'link' => get_post_type_archive_link(get_post_type()) . "?category=" . $strTermSlug
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
			$page->url = get_permalink($page->ID);

			// Bild
			$page->image = get_the_post_thumbnail($page->ID);
			$page->image_url = get_the_post_thumbnail_url($page->ID);
			
			// Publicerad datum
			$page->date = get_the_date('Y-m-d', $page->ID);
	        
			$page->ingress = get_field('name_1000142', $page->ID);
	
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
		           'link' => get_post_type_archive_link(get_post_type($ID)) . "?category=" . $termSlug
		        ));
     		}
        }

        // Returnera arrayen med alla kategorier
        return $myTerms;
	    
	}

	function get_region_halland_page_news_taxonomi_category($myAntal = 4) {

		// Wordpress funktion för aktuell post
		global $post;
		
		// Databas connection
		global $wpdb; 

		// Select
		$sql = "";
		$sql .= "SELECT R.object_id ";
		$sql .= "FROM wp_term_relationships R "; 
		
		// Join
		$sql .= "INNER JOIN wp_posts P ON R.object_id = P.ID ";
		
		// Where
		$sql .= "WHERE R.term_taxonomy_id IN ";
		$sql .= "( ";
			$sql .= "SELECT term_taxonomy_id ";
			$sql .= "FROM wp_term_relationships "; 
			$sql .= "WHERE object_id = $post->ID ";
		$sql .= ") ";
		$sql .= "AND ";
			$sql .= "R.object_id <> $post->ID ";
		$sql .= "AND ";
			$sql .= "P.post_status = 'publish' ";
		$sql .= "ORDER BY P.post_date DESC ";
		$sql .= "LIMIT " . $myAntal;
				
		$arrIDs = $wpdb->get_results($sql, ARRAY_A);
		
		// Skapa array med länkar
        $myPosts = array();
        
        // Loopa igenom alla id
        foreach ($arrIDs as $myIDs) {
        	
        	// Hämta lite data
        	$myID = $myIDs['object_id'];
        	$page = get_post($myID);
			$pageUrl = get_permalink($page->ID);
			$pageImage = get_the_post_thumbnail($page->ID);
			$pageImageUrl = get_the_post_thumbnail_url($page->ID);
			$pageDate = get_the_date('Y-m-d', $page->ID);
			$pageTerms = get_region_halland_news_archive_taxonomi_category_terms($page->ID);
	    	$strIngress = get_field('name_1000142', $page->ID);
	        
			// Placera datana i tmp-arrayen
	        array_push($myPosts, array(
	           'ID' => $myID,
	           'title' => $page->post_title,
	           'permalink' => $pageUrl,
	           'date' => $pageDate,
	           'content' => $page->post_content,
	           'ingress' => $strIngress,
	           'image' => $pageImage,
	           'image_url' => $pageImageUrl,
	           'page_terms' => $pageTerms
	        ));

        }

		// Returnera tmp-arrayen
		return $myPosts;

	}

	function get_region_halland_page_news_taxonomi_category_ingress() {
		return get_field('name_1000142');		
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