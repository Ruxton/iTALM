<?php
class ITALM_List_Table extends WP_List_Table {
  function __construct() {
    global $status, $page;
     parent::__construct( array(
      'singular'  => 'item',     //singular name of the listed records
      'plural'    => 'items',    //plural name of the listed records
      'ajax'      => false        //does this table support ajax?
    ));
  }

  function column_default($item, $column_name) {
    switch($column_name) {
      case 'title':
        return $item[$column_name];
      default:
        return print_r($item,true);
    }
  }

  function column_title($item) {
    $actions = array(
      'edit'    => sprintf('<a href="?page=%s&action=%s&item=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
      'delete'  => sprintf('<a href="?page=%s&action=%s&item=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID'])
    );

    return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
      /*$1%s*/ $item['title'],
      /*$2%s*/ $item['ID'],
      /*$3%s*/ $this->row_actions($actions)
    );
  }

  function column_cb($item){
    return sprintf(
      '<input type="checkbox" name="%1$s[]" value="%2$s" />',
      /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
      /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
    );
  }

  function get_columns(){
    $columns = array(
      'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
      'date'      => 'Date',
      'title'     => 'Title',
      'itms_link' => 'iTMS Link'
    );
    return $columns;
  }

  function get_bulk_actions() {
    $actions = array(
      'delete'    => 'Delete'
    );
    return $actions;
  }

  function process_bulk_action() {
    //Detect when a bulk action is being triggered...
    if( 'delete'===$this->current_action() ) {
      wp_die('Items deleted (or they would be if we had items to delete)!');
    }
  }

  function prepare_items() {
    global $wpdb;

    $per_page = 5;
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $table_name = $wpdb->prefix.'italm';


    $this->_column_headers = array($columns, $hidden, $sortable);

    $this->process_bulk_action();

    $current_page = $this->get_pagenum();
    $page_limit = ($current_page-1)*$per_page;

    $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM ".$table_name.";");
    $this->items = $wpdb->get_results('SELECT * FROM '.$table_name.' ORDER BY updateTime DESC LIMIT '.$page_limit.','.$per_page,OBJECT );

    $this->set_pagination_args(array(
      "total_items" => $total_items,
      "per_page" => $per_page,
      "total_pages" => ceil($total_items/$per_page)
    ));


  }

}
?>