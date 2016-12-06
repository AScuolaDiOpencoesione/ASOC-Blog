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
				
				$regions ='[{"id":1,"name":"Piemonte","code":"1"},{"id":2,"name":"Valle d\'Aosta","code":"2"},{"id":3,"name":"Lombardia","code":"3"},{"id":4,"name":"Trentino-Alto Adige","code":"4"},{"id":5,"name":"Veneto","code":"5"},{"id":6,"name":"Friuli-Venezia Giulia","code":"6"},{"id":7,"name":"Liguria","code":"7"},{"id":8,"name":"Emilia-Romagna","code":"8"},{"id":9,"name":"Toscana","code":"9"},{"id":10,"name":"Umbria","code":"10"},{"id":11,"name":"Marche","code":"11"},{"id":12,"name":"Lazio","code":"12"},{"id":13,"name":"Abruzzo","code":"13"},{"id":14,"name":"Molise","code":"14"},{"id":15,"name":"Campania","code":"15"},{"id":16,"name":"Puglia","code":"16"},{"id":17,"name":"Basilicata","code":"17"},{"id":18,"name":"Calabria","code":"18"},{"id":19,"name":"Sicilia","code":"19"},{"id":20,"name":"Sardegna","code":"20"}]';
				$provinces = '[{"id":1507,"name":"Torino","code":"1","lit":"TO","contained_in":1},{"id":1503,"name":"Verbano-Cusio-Ossola","code":"103","lit":"VB","contained_in":1},{"id":1506,"name":"Vercelli","code":"2","lit":"VC","contained_in":1},{"id":1509,"name":"Novara","code":"3","lit":"NO","contained_in":1},{"id":1504,"name":"Cuneo","code":"4","lit":"CN","contained_in":1},{"id":1508,"name":"Asti","code":"5","lit":"AT","contained_in":1},{"id":1505,"name":"Alessandria","code":"6","lit":"AL","contained_in":1},{"id":1502,"name":"Biella","code":"96","lit":"BI","contained_in":1},{"id":1455,"name":"Perugia","code":"54","lit":"PG","contained_in":10},{"id":1454,"name":"Terni","code":"55","lit":"TR","contained_in":10},{"id":1453,"name":"Fermo","code":"109","lit":"FM","contained_in":11},{"id":1449,"name":"Pesaro e Urbino","code":"41","lit":"PU","contained_in":11},{"id":1451,"name":"Ancona","code":"42","lit":"AN","contained_in":11},{"id":1452,"name":"Macerata","code":"43","lit":"MC","contained_in":11},{"id":1450,"name":"Ascoli Piceno","code":"44","lit":"AP","contained_in":11},{"id":1463,"name":"Viterbo","code":"56","lit":"VT","contained_in":12},{"id":1460,"name":"Rieti","code":"57","lit":"RI","contained_in":12},{"id":1461,"name":"Roma","code":"58","lit":"RM","contained_in":12},{"id":1462,"name":"Latina","code":"59","lit":"LT","contained_in":12},{"id":1464,"name":"Frosinone","code":"60","lit":"FR","contained_in":12},{"id":1457,"name":"L\'Aquila","code":"66","lit":"AQ","contained_in":13},{"id":1458,"name":"Teramo","code":"67","lit":"TE","contained_in":13},{"id":1456,"name":"Pescara","code":"68","lit":"PE","contained_in":13},{"id":1459,"name":"Chieti","code":"69","lit":"CH","contained_in":13},{"id":1471,"name":"Campobasso","code":"70","lit":"CB","contained_in":14},{"id":1470,"name":"Isernia","code":"94","lit":"IS","contained_in":14},{"id":1466,"name":"Caserta","code":"61","lit":"CE","contained_in":15},{"id":1465,"name":"Benevento","code":"62","lit":"BN","contained_in":15},{"id":1467,"name":"Napoli","code":"63","lit":"NA","contained_in":15},{"id":1468,"name":"Avellino","code":"64","lit":"AV","contained_in":15},{"id":1469,"name":"Salerno","code":"65","lit":"SA","contained_in":15},{"id":1475,"name":"Barletta-Andria-Trani","code":"110","lit":"BT","contained_in":16},{"id":1479,"name":"Foggia","code":"71","lit":"FG","contained_in":16},{"id":1476,"name":"Bari","code":"72","lit":"BA","contained_in":16},{"id":1478,"name":"Taranto","code":"73","lit":"TA","contained_in":16},{"id":1474,"name":"Brindisi","code":"74","lit":"BR","contained_in":16},{"id":1477,"name":"Lecce","code":"75","lit":"LE","contained_in":16},{"id":1473,"name":"Potenza","code":"76","lit":"PZ","contained_in":17},{"id":1472,"name":"Matera","code":"77","lit":"MT","contained_in":17},{"id":1491,"name":"Crotone","code":"101","lit":"KR","contained_in":18},{"id":1493,"name":"Vibo Valentia","code":"102","lit":"VV","contained_in":18},{"id":1489,"name":"Cosenza","code":"78","lit":"CS","contained_in":18},{"id":1492,"name":"Catanzaro","code":"79","lit":"CZ","contained_in":18},{"id":1490,"name":"Reggio di Calabria","code":"80","lit":"RC","contained_in":18},{"id":1559,"name":"Reggio Calabria","code":"RC","lit":"RC","contained_in":18},{"id":1481,"name":"Trapani","code":"81","lit":"TP","contained_in":19},{"id":1484,"name":"Palermo","code":"82","lit":"PA","contained_in":19},{"id":1488,"name":"Messina","code":"83","lit":"ME","contained_in":19},{"id":1480,"name":"Agrigento","code":"84","lit":"AG","contained_in":19},{"id":1485,"name":"Caltanissetta","code":"85","lit":"CL","contained_in":19},{"id":1487,"name":"Enna","code":"86","lit":"EN","contained_in":19},{"id":1482,"name":"Catania","code":"87","lit":"CT","contained_in":19},{"id":1486,"name":"Ragusa","code":"88","lit":"RG","contained_in":19},{"id":1483,"name":"Siracusa","code":"89","lit":"SR","contained_in":19},{"id":1522,"name":"Valle d\'Aosta","code":"7","lit":"AO","contained_in":2},{"id":1501,"name":"Olbia-Tempio","code":"104","lit":"OT","contained_in":20},{"id":1495,"name":"Ogliastra","code":"105","lit":"OG","contained_in":20},{"id":1494,"name":"Medio Campidano","code":"106","lit":"VS","contained_in":20},{"id":1496,"name":"Carbonia-Iglesias","code":"107","lit":"CI","contained_in":20},{"id":1500,"name":"Sassari","code":"90","lit":"SS","contained_in":20},{"id":1499,"name":"Nuoro","code":"91","lit":"NU","contained_in":20},{"id":1498,"name":"Cagliari","code":"92","lit":"CA","contained_in":20},{"id":1497,"name":"Oristano","code":"95","lit":"OR","contained_in":20},{"id":1514,"name":"Monza e della Brianza","code":"108","lit":"MB","contained_in":3},{"id":1516,"name":"Varese","code":"12","lit":"VA","contained_in":3},{"id":1520,"name":"Como","code":"13","lit":"CO","contained_in":3},{"id":1513,"name":"Sondrio","code":"14","lit":"SO","contained_in":3},{"id":1521,"name":"Milano","code":"15","lit":"MI","contained_in":3},{"id":1518,"name":"Bergamo","code":"16","lit":"BG","contained_in":3},{"id":1510,"name":"Brescia","code":"17","lit":"BS","contained_in":3},{"id":1512,"name":"Pavia","code":"18","lit":"PV","contained_in":3},{"id":1517,"name":"Cremona","code":"19","lit":"CR","contained_in":3},{"id":1511,"name":"Mantova","code":"20","lit":"MN","contained_in":3},{"id":1519,"name":"Lecco","code":"97","lit":"LC","contained_in":3},{"id":1515,"name":"Lodi","code":"98","lit":"LO","contained_in":3},{"id":1531,"name":"Bolzano","code":"21","lit":"BZ","contained_in":4},{"id":1530,"name":"Trento","code":"22","lit":"TN","contained_in":4},{"id":1523,"name":"Verona","code":"23","lit":"VR","contained_in":5},{"id":1526,"name":"Vicenza","code":"24","lit":"VI","contained_in":5},{"id":1527,"name":"Belluno","code":"25","lit":"BL","contained_in":5},{"id":1524,"name":"Treviso","code":"26","lit":"TV","contained_in":5},{"id":1529,"name":"Venezia","code":"27","lit":"VE","contained_in":5},{"id":1528,"name":"Padova","code":"28","lit":"PD","contained_in":5},{"id":1525,"name":"Rovigo","code":"29","lit":"RO","contained_in":5},{"id":1538,"name":"Udine","code":"30","lit":"UD","contained_in":6},{"id":1536,"name":"Gorizia","code":"31","lit":"GO","contained_in":6},{"id":1539,"name":"Trieste","code":"32","lit":"TS","contained_in":6},{"id":1537,"name":"Pordenone","code":"93","lit":"PN","contained_in":6},{"id":1535,"name":"Genova","code":"10","lit":"GE","contained_in":7},{"id":1532,"name":"La Spezia","code":"11","lit":"SP","contained_in":7},{"id":1533,"name":"Imperia","code":"8","lit":"IM","contained_in":7},{"id":1534,"name":"Savona","code":"9","lit":"SV","contained_in":7},{"id":1557,"name":"Piacenza","code":"33","lit":"PC","contained_in":8},{"id":1554,"name":"Parma","code":"34","lit":"PR","contained_in":8},{"id":1553,"name":"Reggio nell\'Emilia","code":"35","lit":"RE","contained_in":8},{"id":1558,"name":"Modena","code":"36","lit":"MO","contained_in":8},{"id":1550,"name":"Bologna","code":"37","lit":"BO","contained_in":8},{"id":1556,"name":"Ferrara","code":"38","lit":"FE","contained_in":8},{"id":1552,"name":"Ravenna","code":"39","lit":"RA","contained_in":8},{"id":1551,"name":"Forli\'-Cesena","code":"40","lit":"FC","contained_in":8},{"id":1555,"name":"Rimini","code":"99","lit":"RN","contained_in":8},{"id":1544,"name":"Prato","code":"100","lit":"PO","contained_in":9},{"id":1542,"name":"Massa-Carrara","code":"45","lit":"MS","contained_in":9},{"id":1548,"name":"Lucca","code":"46","lit":"LU","contained_in":9},{"id":1546,"name":"Pistoia","code":"47","lit":"PT","contained_in":9},{"id":1545,"name":"Firenze","code":"48","lit":"FI","contained_in":9},{"id":1549,"name":"Livorno","code":"49","lit":"LI","contained_in":9},{"id":1540,"name":"Pisa","code":"50","lit":"PI","contained_in":9},{"id":1547,"name":"Arezzo","code":"51","lit":"AR","contained_in":9},{"id":1543,"name":"Siena","code":"52","lit":"SI","contained_in":9},{"id":1541,"name":"Grosseto","code":"53","lit":"GR","contained_in":9}]';
				$octopics = '[{"id":1,"name":"Ricerca e innovazione"},{"id":2,"name":"Agenda digitale"},{"id":3,"name":"Competitività imprese"},{"id":4,"name":"Energia"},{"id":5,"name":"Ambiente"},{"id":6,"name":"Cultura e turismo"},{"id":7,"name":"Trasporti"},{"id":8,"name":"Occupazione"},{"id":9,"name":"Inclusione sociale"},{"id":10,"name":"Infanzia e anziani"},{"id":11,"name":"Istruzione"},{"id":12,"name":"Citta\' e aree rurali"},{"id":13,"name":"Rafforzamento PA"}]';
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
				
				echo '<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>';
				echo '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';
				echo "<div id='map'></div>";
				echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />';
				echo '<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>';
				echo '<script src="https://cdn.rawgit.com/hiasinho/Leaflet.vector-markers/master/dist/leaflet-vector-markers.min.js"></script>';
				echo '<link rel="stylesheet" href="https://cdn.rawgit.com/hiasinho/Leaflet.vector-markers/master/dist/leaflet-vector-markers.css" />';
				echo '<script>';
				echo 'var bglayer = L.tileLayer("http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png", {';
				echo '	attribution: "&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors, &copy; <a href=\"https://carto.com/attributions\">CARTO</a>"';
				echo '});';
				echo 'var map = L.map("map").setView([42.45588764197166, 13.9306640625], 5.5);';
				echo 'var icon = L.VectorMarkers.icon({icon:"university", markerColor:"#ec6858", "prefix":"fa"});';
				echo '$.getJSON("http://api.ascuoladiopencoesione.it/partner/schools/geojson", function(data){ geojsonLayer = L.geoJson(data, {pointToLayer:function (feature, latlng) { return L.marker(latlng, {icon:icon}); } }); map.addLayer(geojsonLayer); });';
				echo 'map.addLayer(bglayer);';
				echo '</script>';
				
				/* filters */
				echo "<div class='container' style='width:50%;margin-left:25%;margin-right:25%;'>";
				
				echo "<div class='' style='width:30%;float:left;'>";
				echo "<select data-sel='region'>";
					echo "<option>Seleziona una Regione</option>";
				foreach($regions as $r) 
					echo "<option value='{$r->id}'>{$r->name}</option>";
				echo "</select>";
				echo "</div>";
				echo "<div class='' style='width:30%;float:left;'>";
				echo "<select data-sel='provinces'>";
					echo "<option>Seleziona una Provincia</option>";
				foreach($provinces as $r) 
					echo "<option value='{$r->id}'>{$r->name}</option>";
				echo "</select>";
				echo "</div>";
				echo "<div class='' style='width:30%;float:right;'>";
				echo "<select data-sel='octopics'>";
					echo "<option>Seleziona un Tema OpenCoesione</option>";
				foreach($octopics as $r) 
					echo "<option value='{$r->id}'>{$r->name}</option>";
				echo "</select>";
				echo "</div>";
				
				echo "</div>";
			}
			
			echo "<div class='container'>";
			echo "<div class='flex_column av_three_fourth  flex_column_div first  avia-builder-el-0  el_before_av_one_fourth  avia-builder-el-first'>";
			
			if($wp->query_vars["asoc_mode"] == "blog"){
				echo "<div class='teams'>";
				//var_dump($teams);
				foreach($teams as $t){
					//<a target="_blank" href="?team=1421"><div class="team_name">Work In Progress</div><div class="argomento">Tema: Inclusione sociale</div><div class="school_name">Liceo Scientifico "Francesco La Cava"</div><div class="school_name">Bovalino (RC)</div></a>
					echo "<a href='/blogs/{$section->id}/{$t->id}' class='school_{$t->id}' style='color:black;'>";
						echo "<div class='team block datablock' style='background-image:url({$t->details->profile_image});'>";
						echo "<h3>{$t->details->name}</h3>";
						echo "<center>{$t->school->name}</center>";
						echo "<center>{$t->school->city}</center>";
						echo "<center style='font-size:0.8em'>{$t->aplication->school_province}</center>";
						echo "</div>";
					echo "</a>";
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
