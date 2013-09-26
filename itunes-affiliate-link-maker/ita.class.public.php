<?php

class itapub extends itabase
{

	private $pagename = '';

	public function ita_return_query(&$query)
	{
		$query->is_404 = true;
		$query->did_permalink = true;
	}

	public function ita_return_request($query_vars)
	{
		$query_vars['error'] = true;
		return $query_vars;
	}

	public function ita_parse_query(&$query) {
		$query->is_404 = false;
		$query->did_permalink = false;
	}

	public function ita_request($query_vars) {
		$query_vars['error'] = false;
		if(isset($query_vars['pagename']))
			$this->pagename = $query_vars['pagename'];
		return $query_vars;
	}

	public function ita_linkredir( )
	{
		print $this->pagename;
		if($this->pagename == '' || $this->pagename == itabase::setting('ita-maskurl') )
		{
			header(404);
			add_action('template_redirect', 'redirect_canonical');
		}
		else
		{
			global $wpdb;

			$tableName = $wpdb->prefix.'italm';

			$linkName = str_replace(array(itabase::setting('ita-maskurl').'/'),array(''), $this->pagename );
			$query = sprintf("SELECT * FROM %s WHERE linkName = '%s'", $tableName, urldecode($linkName) );
			$row = $wpdb->get_row($query);
			if(sizeof($row) < 1)
			{
				header(404);
				add_action('template_redirect', 'redirect_canonical');
			}
			else
			{
				$link = $row->linkUrl;
				$partnerId = itabase::setting('ita-partner');
				$affilateNetwork = itabase::setting('ita-affiliateNetwork');
				if((trim($partnerId) != "") && trim($affilateNetwork != ""))
				{
					$link = $link."&".$affilateNetwork."=".$partnerId;
				}
				add_action('parse_query', array(&$this, 'ita_parse_query'));
				add_action('parse_request', array(&$this, 'ita_parse_query'));
				header('location: '.$link);
			}
		}
	}

}

?>