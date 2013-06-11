<?php
/*  Copyright 2009  Greg Tangey  (email : greg@digitalignition.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Pagination
{
  private $showOnOne    = true;
  private $currentPage  = 0;
  private $maxItems     = 12;
  private $totalResults = 0;
  private $adjacents    = 3;
  private $preStr       = "";
  private $postStr      = "";
  private $maxPages;
  private $pageJumpBack;
  private $pageSeparator;
  private $pageJumpNext;
  private $url;
  private $endUrl;
  private $buildURL;
  private $backLink;
  private $forwardLink;

  /**
   * Set the links format
   * @param string $prev The previous button html
   * @param string $next The next button html
   * @access public
   */

  public function linksFormat( $prev, $sep, $next, $adjacents = 3 )
  {
    $this->pageJumpBack		= $prev;
    $this->pageSeparator	= $sep;
    $this->pageJumpNext		= $next;
    $this->adjacents      = $adjacents;
  }

  /**
   * Set the text that is put before and after each page number (outside the link)
   * @param string $pre The string to put before the page number
   * @param string $post The string to put after the page number
   * @access public
   */
  public function setExtraText($pre = "", $post = "")
  {
    $this->preStr   = $pre;
    $this->postStr  = $post;
  }

  /**
   * Set the total results number
   * @param int $totalResults The total results
   * @access public
   */

  public function setTotalResults( $totalResults )
  {
    $this->totalResults = abs( $totalResults );
  }

  /**
   * Set the url to build onto
   * @param string $url The url
   * @param string $urlEnd The end of the url
   * @param boolean $buildURL Flag to build the url
   * @access public
   */

  public function setURL( $url, $urlEnd = '', $buildURL = true )
  {
    $this->url = $url;
    $this->endUrl = $urlEnd;
    $this->buildURL = $buildURL;
  }

  /**
   * Set the current page we are on
   * @param int $currentPage The current page
   * @access public
   */

  public function setCurrentPage( $currentPage )
  {
    $this->currentPage = abs( $currentPage );
  }

  /**
   * Set the maximum number of items
   * @param int $maxItems The maximum items limit
   * @access public
   */

  public function setMaxItems( $maxItems )
  {
    $this->maxItems = abs( $maxItems );
  }

  /**
   * Generate the links for pagination
   * @access public
   * @return string
   */

  public function generate( )
  {
    $this->maxPages = ceil( $this->totalResults / $this->maxItems );
    $pagination = "";

        // Don't bother with pagination if theres only 1 page
    if($this->showOnOne == false)
    {
      if($this->maxPages <= 1)
      {
        return $pagination;
      }
    }

    // If currentPage is not set or 0, set it to 1
    if($this->currentPage == 0)
        $this->currentPage = 1;

    /*
     * Previous link
     */
    if($this->currentPage > 1)
      $this->backLink = "<span class=\"previous\"><a href=\"" . $this->buildURL( $this->url . "&ita-pg=" . ($this->currentPage-1) ) . "\">" . $this->pageJumpBack . "</a></span>";
    else
      $this->backLink = "<span class=\"previous disabled\">".$this->pageJumpBack."</span>";


    /*
     * Next Link
     */

    if ($this->currentPage <= $this->maxPages-1)
      $this->forwardLink .= "<span class=\"next\"><a href=\"".$this->buildURL( $this->url . "&ita-pg=" . ($this->currentPage+1) ) . "\">" . $this->pageJumpNext . "</a></span>";
    else
      $this->forwardLink .= "<span class=\"next disabled\">".$this->pageJumpNext."</span>";



    if( $this->maxPages < 5 + ($this->adjacents * 2) )
    {
      for ($counter = 1; $counter <= $this->maxPages; $counter++)
      {
        $pagination .= $this->preStr . "<a href=\"" . $this->buildURL( $this->url . "&ita-pg=".$counter ) . "\">" . $counter . "</a>" . $this->postStr . $this->pageSeparator;
      }
    }
    else	//enough pages to hide some
    {
        //close to beginning; only hide later pages
      if($this->currentPage < 1 + ($this->adjacents * 2))
      {
        for ($counter = 1; $counter < 2 + ($this->adjacents * 2); $counter++)
        {
          $pagination.= $this->preStr . "<a href=\"".$this->buildURL( $this->url . "&ita-pg=".$counter )."\">$counter</a>" . $this->postStr . $this->pageSeparator;
        }
        $pagination.= "..." . $this->pageSeparator;
        $pagination.= $this->preStr . "<a href=\"".$this->buildURL( $this->url . "&ita-pg=" . $this->maxPages-1 )."\">".($this->maxPages-1)."</a>" . $this->postStr . $this->pageSeparator;
        $pagination.= $this->preStr . "<a href=\"".$this->buildURL( $this->url . "&ita-pg=" . $this->maxPages )."\">".($this->maxPages)."</a>" . $this->postStr . $this->pageSeparator;
      }

      //in middle; hide some front and some back
      elseif($this->maxPages - ($this->adjacents * 2) > $this->currentPage&& $this->currentPage > ($this->adjacents * 2))
      {
        $pagination.= $this->preStr . "<a href=\"".$this->buildURL($this->url . "&ita-pg=1")."\">1</a>" . $this->postStr . $this->pageSeparator;
        $pagination.= $this->preStr . "<a href=\"".$this->buildURL($this->url . "&ita-pg=2")."\">2</a>" . $this->postStr . $this->pageSeparator;
        $pagination.= "...".$this->pageSeparator;
        for ($counter = $this->currentPage - $this->adjacents; $counter <= $this->currentPage + $this->adjacents; $counter++)
        {
          $pagination.= $this->preStr . "<a href=\"" . $this->buildURL($this->url . "&ita-pg=". $counter) . "\">$counter</a>" . $this->postStr . $this->pageSeparator;
        }
        $pagination.= "..." . $this->pageSeparator;
        $pagination.= $this->preStr . "<a href=\"" . $this->buildURL($this->url . "&ita-pg=". $this->maxPages-1) . "\">".($this->maxPages-1)."</a>" . $this->postStr . $this->pageSeparator;
        $pagination.= $this->preStr . "<a href=\"" . $this->buildURL($this->url . "&ita-pg=". $this->maxPages) . "\">".($this->maxPages)."</a>" . $this->postStr . $this->pageSeparator;
      }

      //close to end; only hide early pages
      else
      {
        $pagination.= $this->preStr . "<a href=\"".$this->buildURL( $this->url . "&ita-pg=1" )."\">1</a>" . $this->postStr . $this->pageSeparator;
        $pagination.= $this->preStr . "<a href=\"".$this->buildURL( $this->url . "&ita-pg=2" )."\">2</a>" . $this->postStr . $this->pageSeparator;
        $pagination.= "..." . $this->pageSeparator;
        for ($counter = $this->maxPages - (1 + ($this->adjacents * 2)); $counter <= $this->maxPages; $counter++)
        {
          $pagination.= $this->preStr . "<a href=\"".$this->buildURL( $this->url . "&ita-pg=".$counter )."\">$counter</a>" . $this->postStr . $this->pageSeparator;
        }
      }
    }

    if(substr($pagination, -1) == $this->pageSeparator )
    {
      $pagination = substr($pagination, 0, -1);
    }

    $return = $this->backLink . $pagination . $this->forwardLink;

    return $return;
  }

  /**
   * Build the url
   * @param string $url The url to build
   * @access private
   */

  private function buildURL( $url )
  {
    if ( !empty( $this->endUrl ) )
    {
      $url = $url . $this->endUrl;
    }

    return $url;
  }
}

?>