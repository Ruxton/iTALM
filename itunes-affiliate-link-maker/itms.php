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

    const ARTIST_LINK       = "<a href=\"{artistLinkUrl}\">{artistName}></a>";
    const ARTIST_VIEW       = "<a href=\"{artistViewUrl}\">{artistName}</a>";
    const TRACK_VIEW        = "<a href=\"{trackViewUrl}\">{trackName}</a>";
    const COLLECTION_VIEW   = "<a href=\"{collectionViewUrl}\">{collectionName}</a>";
    const PREVIEW_LINK      = "<a href=\"{previewUrl}\">preview</a>";

    
	public static $entities = array (
        "ping" => array(
          
        ),
        "software" => array(
            "softwareDeveloper" => array (
                "name" => "Developer",
                "columns" => array(
                    "Name" => self::ARTIST_LINK
                )
            ),
            "software" => array(
                "name" => "iPhone Apps",
                "columns" => array(
                    "Name" => "<a href=\"{trackViewUrl}\">{trackName}</a>",
                    "Developer" => self::ARTIST_VIEW,
                    "Category" => "{genres[0]}",
                    "Date" => "{releaseDate}",
                )
            ),
            "iPadSoftware" => array (
                "name" => "iPad Apps",
                "columns" => array(
                    "Name" => "<a href=\"{trackLinkUrl}\">{trackName}</a>",
                    "Developer" => self::ARTIST_VIEW,
                    "Category" => "{genres[0]}",
                    "Date" => "{releaseDate}",
                )
            )
        ),
		"music" => array(
			"musicArtist" => array( 
                "name" => "Artist",
                "columns" => array(
                    "Name" => self::ARTIST_LINK,
                    "Genre" => "{primaryGenreName}"
                )
            ),
			"musicTrack" => array( 
                "name" => "Track",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Track Name" => self::TRACK_VIEW,
                    "Release" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Preview" => self::PREVIEW_LINK
                )
            ),
			"album" => array(
                "name" => "Album",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Album Name" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Date" => "{releaseDate}"
                )
            ),
			"musicVideo" => array(
                "name" => "Music Video",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Track Name" => self::TRACK_VIEW,
                    "Release" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Preview" => self::PREVIEW_LINK
                )
            ),
			"mix" => array( 
                "name" => "iTunes Mix",
                "columns" => array(
                    "Mix Title" => "<a href=\"{collectionViewUrl}\">{title}</a>",
                    "Artist" => "{artistName}"
                )
            )
		),
		"movie" => array(
			"movieArtist" => array(
                "name" => "Movie Artist",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"movie" => array(
                "name" => "Movie",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            )
		),
		"podcast" => array(
			"podcastAuthor" => array(
                "name" => "Podcast Author",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"podcast" => array(
                "name" => "Podcast",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            )
		),
		"audiobook" => array(
			"audiobookAuthor" => array(
                "name" => "Author",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"audiobook" => array(
                "name" => "Audiobook",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            )
		),
		"shortFilm" => array(
			"shortFilmArtist" => array(
                "name" => "Artist",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"shortFilm" => array(
                "name" => "Short Film",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            )
		),
		"tvShow" => array(
			"tvEpisode" => array(
                "name" => "TV Episode",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"tvSeason" => array(
                "name" => "TV Season",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            )
		),
		"all" => array(
			"movie" => array(
                "name" => "Movie Title",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"album" => array(
                "name" => "Album Title",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"allArtist" => array(
                "name" => "Artists",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"podcast" => array(
                "name" => "Podcasts",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"musicVideo" => array(
                "name" => "Music Video",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"mix" => array(
                "name" => "iTunes Mix",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"audiobook" => array(
                "name" => "Audiobook",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"tvSeason" => array(
                "name" => "TV Season",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            ),
			"allTrack" => array(
                "name" => "Everything",
                "columns" => array(
                    "Name" => "<a href=\"{}\">{}</a>",
                )
            )
        )
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
