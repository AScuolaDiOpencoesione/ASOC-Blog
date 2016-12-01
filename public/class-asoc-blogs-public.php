<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ingmmo.com
 * @since      1.0.0
 *
 * @package    Asoc_Blogs
 * @subpackage Asoc_Blogs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Asoc_Blogs
 * @subpackage Asoc_Blogs/public
 * @author     Marco Montanari <marco.montanari@gmail.com>
 */
class Asoc_Blogs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		

	}
	
	public function myplugin_flush_rewrites() {
		flush_rewrite_rules();
	}
	public function wpse9870_init_internal()
	{
	    add_rewrite_rule( 'blogs/([^/]*)/([^/]*)/([^/]*)', 'index.php?asoc_blog=1&asoc_mode=post&asoc_year=$matches[1]&asoc_team=$matches[2]&asoc_post=$matches[3]', 'top' );
	    add_rewrite_rule( 'blogs/([^/]*)/([^/]*)',         'index.php?asoc_blog=1&asoc_mode=team&asoc_year=$matches[1]&asoc_team=$matches[2]', 'top' );
	    add_rewrite_rule( 'blogs/([^/]*)',                 'index.php?asoc_blog=1&asoc_mode=blog&asoc_year=$matches[1]', 'top' );
	    
		add_rewrite_tag('%asoc_blog%', '([^/]*)');
		add_rewrite_tag('%asoc_mode%', '([^/]*)');
		add_rewrite_tag('%asoc_year%', '([^/]*)');
		add_rewrite_tag('%asoc_team%', '([^/]*)');
		add_rewrite_tag('%asoc_post%', '([^/]*)');
	}

	public function wpse9870_query_vars( $query_vars )
	{
	    $query_vars[] = 'asoc_blog';
	    $query_vars[] = 'asoc_mode';
	    $query_vars[] = 'asoc_year';
	    $query_vars[] = 'asoc_team';
	    $query_vars[] = 'asoc_post';
	    return $query_vars;
	}
	public function wpse9870_parse_request( &$wp )
	{
		if ( array_key_exists( 'asoc_blog', $wp->query_vars ) ) {
			
			$regions = array(); 
			$provinces = array(); 
			$octopics = array(); 
			$teams = array(); 
			
			$section = array();
			$team = array();
			$post = array();
			
			if($wp->query_vars["asoc_mode"] == "blog"){
				
				$regions = file_get_contents('http://api.ascuoladiopencoesione.it/region/');
				$provinces = file_get_contents('http://api.ascuoladiopencoesione.it/province/');
				$octopics = file_get_contents('http://api.ascuoladiopencoesione.it/octopic/');
				$teams = file_get_contents('http://api.ascuoladiopencoesione.it/team/');
				
				$regions = json_decode($regions);
				$provinces = json_decode($provinces);
				$octopics = json_decode($octopics);
				$teams = json_decode($teams);
				
				$surl = "http://api.ascuoladiopencoesione.it/core/section/".$wp->query_vars["asoc_year"];
				//echo($surl);
				$section_raw = file_get_contents($surl);
				//echo $section_raw;
				$section = json_decode($section_raw);
				//var_dump($section);
			} elseif($wp->query_vars["asoc_mode"] == "team"){
				$section_raw = file_get_contents("http://api.ascuoladiopencoesione.it/core/section/".$wp->query_vars["asoc_year"]);
				//echo $section_raw;
				$section = json_decode($section_raw);
				$team_raw = file_get_contents("http://api.ascuoladiopencoesione.it/team/".$wp->query_vars["asoc_team"]);
				//echo $team_raw;
				$team = json_decode($team_raw);
				//var_dump($team);
			} elseif(get_query_var-("asoc_mode") == "post"){
				$section_raw = file_get_contents("http://api.ascuoladiopencoesione.it/core/section/".$wp->query_vars["asoc_year"]);
				//echo $section_raw;
				$section = json_decode($section_raw);
				$team_raw = file_get_contents("http://api.ascuoladiopencoesione.it/team/".$wp->query_vars["asoc_team"]);
				//echo $team_raw;
				$team = json_decode($team_raw);
				$post_raw = file_get_contents("http://api.ascuoladiopencoesione.it/meta/compiledform/".$wp->query_vars["asoc_post"]);
				//echo $post_raw;
				$post = json_decode($post_raw);
				//var_dump($post_raw);
			}
			
			$style = '
<style type="text/css">	
#map{
	height: 500px;
}

.block{
	height: 286px;
	width: 286px;
	border:1px solid lightgray;
	float: 	left;	
	margin: 5px;
	padding:5px;		
}
  
.shortblock{
	height: 143px;
	width: 286px;
	border:1px solid lightgray;
	float: 	left;	
	margin: 5px;
	padding:5px;	
    background-color:white;
    text-align:center
}
  
  main .shortblock{
    display:none;
  }

.block:hover{
	box-shadow: 0 0 3px black;
}

.block{
	background-size:cover; 
	background-position:center center; 
}
.block *{
	text-align: center;
	background-color: rgba(255,255,255,0.85);
	padding: 5px;
	margin-left: -5px;
	margin-right: -5px;
	margin-top: -8px;
}

.block .team_name{
	font-size: 16px;
}

.block .argomento{
	font-size: 	10px;
	color: 	gray;
	font-style: italic;
}

.block .school_name{
	font-size: 12px;
	color: 	gray;
}

.container_wrap{
	border-style: none;
}

</style>
';
			
			echo $style;
			get_header();
			/*STUCTURAL DATA*/
			//var_dump($wp->query_vars["asoc_mode"]);
			$x = $wp->query_vars["asoc_mode"];
			//var_dump($x);
			//var_dump($section);
			//var_dump($team);
			//var_dump($post);

			//TITLE

			if($wp->query_vars["asoc_mode"] == "blog"){
				echo "<div class='container'>";
				echo "<h1>Blog Scuole {$section->name}</h1>";
				echo "</div>";
			} elseif($wp->query_vars["asoc_mode"] == "team"){
				echo '<div class="container">';
				echo '<div class="nav">';
				echo "<a href='/blogs/{$section->id}'><i class='fa fa-fw fa-chevron-left'></i> Tutte le scuole</a>";
				echo '</div>';
				echo '</div>';
				echo "<div class='container'>";
				echo "<h1>Blog Team Scuola {$team->details->name}</h1>";
				echo "</div>";
			} elseif($wp->query_vars["asoc_mode"] == "post"){
				echo '<div class="container">';
				echo '<div class="nav">';
				echo "<a href='/blogs/{$section->id}'><i class='fa fa-fw fa-chevron-left'></i> Tutte le scuole</a>";
				echo " - <a href='/blogs/{$section->id}/{$team->id}'><i class='fa fa-fw fa-chevron-left'></i> Blog Team</a>";
				echo '</div>';
				echo '</div>';
				
				echo "<div class='container'>";
				echo "<h1>Blog Team Scuola {$team->details->name}</h1>";
				echo "<h2>Report {$post->name}</h2>";
				echo "</div>";
			} else {
				echo "ERRORE";
			}
			
			if($wp->query_vars["asoc_mode"] == "blog"){
				/*map*/
				echo "<div id='map'></div>";
				echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />';
				echo '<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>';
				echo '<script>
				var bglayer = L.tileLayer("http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png", {
					attribution: "&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://carto.com/attributions">CARTO</a>"
				});
				var map = L.map("map").setView([51.505, -0.09], 13);
				map.addLayer(layer);
				</script>';
				/* filters */
				echo "<div>";
				echo "</div>";
			}
			
			echo "<div class='container'>";
			echo "<div class='flex_column av_three_fourth  flex_column_div first  avia-builder-el-0  el_before_av_one_fourth  avia-builder-el-first'>";
			
			if($wp->query_vars["asoc_mode"] == "blog"){
				echo "<div class='teams'>";
				//var_dump($teams);
				foreach($teams as $t){
					echo "<div class='team block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$t->id}'>{$t->school->name}</a>";
					echo "</div>";
				}
				echo "</div>";
			}
			if($wp->query_vars["asoc_mode"] == "team"){
				if($team->lesson_1_form_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_1_form}'>Report Lezione 1</a>";
					echo "</div>";
				}
				if($team->lesson_2_form_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_2_form}'>Report Lezione 2</a>";
					echo "</div>";
				}
				if($team->lesson_3_form_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_3_form}'>Report Lezione 3</a>";
					echo "</div>";
				}
				if($team->lesson_3_form_event_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_3_form_event}'>Report Lezione 3 - Open Data Day</a>";
					echo "</div>";
				}
				if($team->lesson_3_form_post_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_3_form_post}'>Report Lezione 3 - Resoconto Open Data Day</a>";
					echo "</div>";
				}
				if($team->lesson_4_form_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_4_form}'>Report Lezione 4</a>";
					echo "</div>";
				}
				if($team->lesson_5_form_published){
					echo "<div class='report block datablock'>";
					echo "<a href='/blogs/{$section->id}/{$team->id}/{$team->lesson_5_form}'>Report Lezione 5</a>";
					echo "</div>";
				} 
			}
				
			if($wp->query_vars["asoc_mode"] == "post"){
				/* Post */
				echo "<h1>".$post->name."</h1>";
				echo "<hr>";
				
				foreach($post->form->fields as $ffield){
					echo "<h2>".$ffield->label."</h2>";
					foreach($post->fields as $field){
						if ($field->field == $ffield->id){
							switch($ffield->t->t){
								case "url":
									echo "<a href={$field->value}>{$field->value}</p>";
								default:
									echo "<p>{$field->value}</p>";
							}
						}
					}
				}
			}
			
			echo "</div>";
			
			/* SIDEBAR */
			
			echo "<div class='flex_column av_one_fourth  flex_column_div   avia-builder-el-2  el_after_av_three_fourth  avia-builder-el-last'>";
			
			if ($wp->query_vars["asoc_mode"] == "blog"){
				//LATEST POSTS
				echo "<h3>Gli ultimi post</h3>";
			} else {
				//TEAM PROFILE
				echo "<center>";
				echo "<img width='495' height='302' src='{$team->details->profile_image}'>";
				echo "<h2>{$team->details->name}</h2>";
				echo "<div class='school_name'>{$team->school->name}</div>";
				echo "<div class='school_name'>{$team->application->school_municipality}</div>";
				echo "<hr>";
				
				if($team->lesson_1_form){
					echo "<div>Progetto OpenCoesione: ";
					echo "<a href='{$team->lesson_1_form->oc_link}' target='_blank'><i class='fa fa-fw fa-world'></i>{$team->lesson_1_form->oc_name}</a>";
					echo '</div>';
				}
				//echo '<div title="Tutte le scuole con tema Trasporti"><a href="?tema=Trasporti"><i class="fa fa-fw fa-tag"></i>Trasporti</a></div>';
				//echo '<hr>';
				echo "<div><i class='fa fa-fw fa-user'></i>{$team->support_edics[0]->name}</div>";
				echo "<div><i class='fa fa-fw fa-users'></i>{$team->support_associations[0]->name}</div>";
				echo '<hr>';
				if($team->details->twitter)
					echo "<div><i class='fa fa-fw fa-twitter'></i><a href='{$team->details->twitter}'>{$team->details->twitter}</a></div>";
				if($team->details->web)
					echo "<div><i class='fa fa-fw'></i><a href='{$team->details->web}'>Sito web</a></div>";
				echo '</center>';
				echo "<hr>";
			}
			
			echo "</div>";
			
			echo "</div>";
			get_footer();
	        exit();
	    }
    return;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Asoc_Blogs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Asoc_Blogs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/asoc-blogs-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Asoc_Blogs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Asoc_Blogs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/asoc-blogs-public.js', array( 'jquery' ), $this->version, false );

	}

}
