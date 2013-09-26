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
        "audiobook" => "Audiobooks",
        "software" => "Software",
        "podcast" => "Podcasts"
    );

    // Timeout variable for remote connection to App Store API
    const __REMOTE_TIMEOUT  = 30;

    const ARTIST_LINK       = "<a href=\"{artistLinkUrl}\" onClick=\"return italm_sendToEditor('{artistName}','{artistLinkUrl}',italmLinkImage);\">{artistName}</a>";
    const ARTIST_VIEW       = "<a href=\"{artistViewUrl}\" onClick=\"return italm_sendToEditor('{artistName}','{artistViewUrl}',italmLinkImage);\">{artistName}</a>";
    const TRACK_LINK        = "<a href=\"{trackLinkUrl}\" onClick=\"return italm_sendToEditor('{trackName}','{trackLinkUrl}',italmLinkImage);\">{trackName}</a>";
    const TRACK_VIEW        = "<a href=\"{trackViewUrl}\" onClick=\"return italm_sendToEditor('{trackName}','{trackViewUrl}',italmLinkImage);\">{trackName}</a>";
    const COLLECTION_VIEW   = "<a href=\"{collectionViewUrl}\" onClick=\"return italm_sendToEditor('{collectionName}','{collectionViewUrl}',italmLinkImage);\">{collectionName}</a>";
    const PREVIEW_LINK      = "<a href=\"{previewUrl}\" target=\"_blank\">preview</a>";


	public static $entities = array (
        "software" => array(
            "allTrack" => array(
                "name" => "Everything",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Track Name" => self::TRACK_VIEW,
                    "Release" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Preview" => self::PREVIEW_LINK
                )
            ),
            "software" => array(
                "name" => "iPhone Apps",
                "columns" => array(
                    "Name" => self::TRACK_VIEW,
                    "Developer" => self::ARTIST_VIEW,
                    "Category" => "{genres[0]}",
                    "Date" => "{releaseDate}",
                )
            ),
            "iPadSoftware" => array (
                "name" => "iPad Apps",
                "columns" => array(
                    "Name" => self::TRACK_VIEW,
                    "Developer" => self::ARTIST_VIEW,
                    "Category" => "{genres[0]}",
                    "Date" => "{releaseDate}",
                )
            ),
            "macSoftware" => array(
                "name" => "Mac Apps",
                "columns" => array(
                    "Name" => self::TRACK_VIEW,
                    "Developer" => self::ARTIST_VIEW,
                    "Category" => "{genres[0]}",
                    "Date" => "{releaseDate}",
                )
            ),
        ),
    	"music" => array(
    	   "allTrack" => array(
                "name" => "All Tracks",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Track Name" => self::TRACK_VIEW,
                    "Release" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Preview" => self::PREVIEW_LINK
                )
            ),
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
                    "Mix Title" => "<a href=\"{collectionViewUrl}\" onClick=\"return italm_sendToEditor('{title}','{collectionViewUrl}',italmLinkImage);\">{title}</a>",
                    "Artist" => "{artistName}"
                )
            )
    	),
    	"movie" => array(
    		"movieArtist" => array(
                "name" => "Movie Artist",
                "columns" => array(
                    "Artist" => self::ARTIST_LINK,
                    "Primary Genre" => "{primaryGenreName}"
                )
            ),
    		"movie" => array(
                "name" => "Movie",
                "columns" => array(
                    "Name" => self::TRACK_VIEW,
                    "Studio" => self::ARTIST_VIEW,
                    "Preview" => self::PREVIEW_LINK
                )
            )
    	),
    	"podcast" => array(
            "podcast" => array(
                "name" => "Podcast",
                "columns" => array(
                    "Podcast" => self::TRACK_VIEW,
                    "Preview" => self::PREVIEW_LINK
                )
            ),
            "podcastAuthor" => array(
                "name" => "Podcast Author",
                "columns" => array(
                    "Name" => self::ARTIST_VIEW,
                )
            )
    	),
    	"audiobook" => array(
            "audiobook" => array(
                "name" => "Audiobook",
                "columns" => array(
                    "Name" => self::COLLECTION_VIEW,
                    "Preview" => self::PREVIEW_LINK
                )
            ),
            "audiobookAuthor" => array(
                "name" => "Author",
                "columns" => array(
                    "Name" => self::ARTIST_LINK,
                )
            )
    	),
    	"shortFilm" => array(
            "shortFilm" => array(
                "name" => "Short Film",
                "columns" => array(
                    "Name" => self::TRACK_VIEW
                )
            ),
    		"shortFilmArtist" => array(
                "name" => "Studio",
                "columns" => array(
                    "Studio" =>  self::ARTIST_LINK
                )
            )
    	),
    	"tvShow" => array(
    		"tvEpisode" => array(
                "name" => "TV Episode",
                "columns" => array(
                    "Show" => self::ARTIST_VIEW,
                    "Season" => self::COLLECTION_VIEW,
                    "Episode" => self::TRACK_VIEW,
                    "Preview" => self::PREVIEW_LINK
                )
            ),
    		"tvSeason" => array(
                "name" => "TV Season",
                "columns" => array(
                    "Show" => self::ARTIST_VIEW,
                    "Season" => self::COLLECTION_VIEW
                )
            )
    	),
    	"all" => array(
      		"allTrack" => array(
                "name" => "All Tracks",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Track Name" => self::TRACK_VIEW,
                    "Release" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Preview" => self::PREVIEW_LINK
                )
            ),
    		"movie" => array(
                "name" => "Movie Title",
                "columns" => array(
                    "Name" => self::TRACK_VIEW,
                    "Studio" => self::ARTIST_VIEW,
                    "Preview" => self::PREVIEW_LINK
                )
            ),
    		"album" => array(
                "name" => "Album Title",
                "columns" => array(
                    "Artist" => self::ARTIST_VIEW,
                    "Album Name" => self::COLLECTION_VIEW,
                    "Genre" => "{primaryGenreName}",
                    "Date" => "{releaseDate}"
                )
            ),
    		"allArtist" => array(
                "name" => "Artists",
                "columns" => array(
                    "Name" => self::ARTIST_LINK,
                    "Genre" => "{primaryGenreName}"
                )
            ),
    		"podcast" => array(
                "name" => "Podcasts",
                "columns" => array(
                    "Podcast" => self::TRACK_VIEW,
                    "Preview" => self::PREVIEW_LINK
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

	public function getResults( $term = "", $media = "all", $country = 'AU', $entity = '', $attribute = '' )
	{
		$queryvars = $this->buildQueryVars( $term, $media, $country, $entity, $attribute );
		$url = $this->source.$queryvars;

		$results = wp_remote_get( $url, array( 'timeout' => itms::__REMOTE_TIMEOUT ) );
		if ( is_wp_error( $results ) )
			return new WP_Error( 'italm', __( 'Can\'t retrieve a result for your search' ) );

		$results = wp_remote_retrieve_body( $results );

		$arr = json_decode($results);
		return $arr;
	}

	private function buildQueryVars($term,$media,$country,$entity,$attribute="")
	{
		$limit = "";

        ## TODO: Remove when Search API bug fixed.
        if($entity == "macSoftware") {
            $media = "";
            $attribute = "allTrackTerm";
        }

		if(itabase::setting('ita-searchlimit') != itabase::$defaultSettings['ita-searchlimit'] )
			$limit = "&limit=".itabase::setting('ita-searchlimit');
                if(trim($entity != ''))
                    $entity = "&entity=".$entity;
                if(trim($attribute != ''))
                    $attribute = "&attribute=".$attribute;
                if(trim($media != ''))
                    $media = "&media=".$media;

		return "&country=".$country."&term=".urlencode($term).$media.$entity.$attribute.$limit;
	}
}
?>
