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
			$regions = file_get_contents('http://api.ascuoladiopencoesione.it/region/');
			$provinces = file_get_contents('http://api.ascuoladiopencoesione.it/province/');
			$octopics = file_get_contents('http://api.ascuoladiopencoesione.it/octopic/');
			$teams = file_get_contents('http://api.ascuoladiopencoesione.it/team/');
			
			$regions = json_decode($regions);
			$provinces = json_decode($provinces);
			$octopics = json_decode($octopics);
			$teams = json_decode($teams);
			
			$section = array();
			$team = array();
			$post = array();
			
			if($wp->query_vars["asoc_mode"] == "blog"){
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
				//var_dump($section_raw);
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
			var_dump($team);
			//var_dump($post);

			if($wp->query_vars["asoc_mode"] == "blog"){
				echo "<div class='container'>";
				echo "<h1>Blog Scuole {$section->name}</h1>";
				echo "</div>";
			} elseif($wp->query_vars["asoc_mode"] == "team"){
				echo "<div class='container'>";
				echo "<h1>Blog Team Scuola {$team->name}</h1>";
				echo "</div>";
			} elseif($wp->query_vars["asoc_mode"] == "post"){
				echo "<div class='container'>";
				echo "<h1>Blog Team Scuola {$team->name}</h1>";
				echo "<h2>Report {$post->name}</h2>";
				echo "</div>";
			} else {
				echo "ERRORE";
			}
			
			/*FORMATS*/
			if($wp->query_vars["asoc_mode"] == "blog"){
				echo "<div id='map'></div>";
			}
			
			if($wp->query_vars["asoc_mode"] == "blog"){
				/* filters */
				echo "<div>";
				echo "</div>";
			}
			
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
				/* Teams */
				echo "<div>POSTS</div>";
			}
				
			if($wp->query_vars["asoc_mode"] == "post"){
				/* Teams */
				echo "<div>POST</div>";
			}
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
