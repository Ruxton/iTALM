<?php

class itapub extends itabase
{

	private $pagename = '';

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
		if($this->pagename == '' || $this->pagename == 'italm' )
		{
			header('location: '.get_option('siteurl'));
		}
		else
		{
			global $wpdb;
			
			$tableName = $wpdb->prefix.'italm';

			$linkName = str_replace(array(itabase::setting('ita-maskurl').'/','_'),array('',' '), $this->pagename );

			$query = sprintf("SELECT * FROM %s WHERE linkName = '%s'", $tableName, str_replace('_',' ',$linkName) );
			$row = $wpdb->get_row($query);
			
			if(sizeof($row) < 1)
			{
				header('location: '.get_option('siteurl'));
			}
			else
			{
				header('location: '.$row->linkUrl);
			}
		}
	}
	
}

?>
