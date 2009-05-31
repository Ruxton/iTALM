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
        "software" => "Applications",
        "musicVideo" => "Music Videos",
        "audiobook" => "Audiobooks",
        "podcast" => "Podcasts",
        "iTunesU" => "iTunes U",
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
             $this->partnerstuff = ita::setting('ita-partner');
             $this->source = ita::setting('ita-itmslm');
        }

	public function getResults( $term = "", $media = "all", $country = 'AU' )
	{
		$queryvars = $this->buildQueryVars( $term, $media, $country );
		$url = $this->source.$this->partnerstuff.$queryvars;
		$results = file_get_contents($url);

		$arr = json_decode($results);
		return $arr;
	}

	private function buildQueryVars($term,$media,$country )
	{
		return "&country=".$country."&term=".urlencode($term)."&media=".$media;
	}
}
?>
