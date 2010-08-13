<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itms
 *
 * @author ruxton
 */
class itms {

    public static $media = array (
        "all" => "All Results",
        "music" => "Music",
        "movie" => "Movies",
        "shortFilm" => "Short Films",
        "tvShow" => "TV Shows",
        "musicVideo" => "Music Videos",
        "audiobook" => "Audiobooks",
	"software" => "Applications",
        "podcast" => "Podcasts",
        "iTunesU" => "iTunes U",
    );

	public static $entities = array (
                "software" => array(
                    "softwareDeveloper" => "Developer",
                    "software" => "iPhone Apps",
                    "iPadSoftware" => "iPad Apps"
                ),
		"music" => array(
			"musicArtist" => "Artist",
			"musicTrack" => "Track",
			"album" => "Album",
			"musicVideo" => "Music Video",
			"mix" => "iTunes Mix"
		),
		"movie" => array(
			"movieArtist" => "Movie Artist",
			"movie" => "Movie"
		),
		"podcast" => array(
			"podcastAuthor" => "Podcast Author",
			"podcast" => "Podcast"
		),
		"audiobook" => array(
			"audiobookAuthor" => "Author",
			"audiobook" => "Audiobook"
		),
		"shortFilm" => array(
			"shortFilmArtist" => "Artist",
			"shortFilm" => "Short Film"
		),
		"tvShow" => array(
			"tvEpisode" => "TV Episode",
			"tvSeason" => "TV Season"
		),
		"all" => array(
			"movie" => "Movie Title",
			"album" => "Album Title",
			"allArtist" => "Artists",
			"podcast" => "Podcasts",
			"musicVideo" => "Music Video",
			"mix" => "iTunes Mix",
			"audiobook" => "Audiobook",
			"tvSeason" => "TV Season",
			"allTrack" => "Everything" )
	);

    public static $countries = array (
        "AR" => "Argentina",
        "AU" => "Australia",
        "AT" => "Austria",
        "BE" => "Belgium",
        "BR" => "Brazil",
        "CA" => "Canada",
        "CL" => "Chile",
        "CN" => "China",
        "CO" => "Colombia",

        "CR" => "Costa Rica",
        "HR" => "Croatia",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DO" => "Dominican Rep.",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "EE" => "Estonia",

        "FI" => "Finland",
        "FR" => "France",
        "DE" => "Germany",
        "GR" => "Greece",
        "GT" => "Guatemala",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IN" => "India",

        "ID" => "Indonesia",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "KZ" => "Kazakstan",
        "KR" => "Korea, Republic Of",
        "KW" => "Kuwait",

        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau",
        "MY" => "Malaysia",
        "MT" => "Malta",
        "MX" => "Mexico",
        "MD" => "Moldova, Republic Of",

        "NL" => "Netherlands",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NO" => "Norway",
        "PK" => "Pakistan",
        "PA" => "Panama",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",

        "PL" => "Poland",
        "PT" => "Portugal",
        "QA" => "Qatar",
        "RO" => "Romania",
        "RU" => "Russia",
        "SA" => "Saudi Arabia",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",

        "ZA" => "South Africa",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "TW" => "Taiwan",
        "TH" => "Thailand",
        "TR" => "Turkey",
        "GB" => "UK",

        "US" => "USA",
        "AE" => "United Arab Emirates",
        "UY" => "Uruguay",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
    );

	//private $source = "itmsSearch.html";
	private $source;
	private $partnerstuff;

	public function itms( )
	{
		 $this->partnerstuff = itabase::setting('ita-partner');
		 $this->source = itabase::setting('ita-itmslm');
	}

	public function getResults( $term = "", $media = "all", $country = 'AU', $entity = '' )
	{
		$queryvars = $this->buildQueryVars( $term, $media, $country, $entity );
		$url = $this->source.$queryvars;

		$results = wp_remote_get( $url, array( 'timeout' => 30 ) );
		if ( is_wp_error( $results ) )
			return new WP_Error( 'italm', __( 'Can\'t retrieve a result for your search' ) );

		$results = wp_remote_retrieve_body( $results );
		//$results = file_get_contents($url);

		$arr = json_decode($results);
//		var_dump($arr);
//		exit;
		return $arr;
	}

	private function buildQueryVars($term,$media,$country,$entity )
	{
		$limit = "";

		if(itabase::setting('ita-searchlimit') != itabase::$defaultSettings['ita-searchlimit'] )
			$limit = "&limit=".itabase::setting('ita-searchlimit');
                if(trim($entity != ''))
                    $entity = "&entity=".$entity;
		return "&country=".$country."&term=".urlencode($term)."&media=".$media.$entity.$limit;
	}
}
?>
