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
      default:
        return print_r($item,true);
    }
  }

  function column_date($item) {
    $date_format=get_option('date_format');
    $time_format=get_option('time_format');
    return date($date_format.' '.$time_format,$item->updateTime);
  }

  function column_itms_link($item) {
    return sprintf('<a href="%s">%s</a>',$item->linkUrl, $item->linkUrl);
  }

  function column_title($item) {
    $actions = array(
      'edit'    => sprintf('<a href="?page=%s&action=%s&item=%s">Edit</a>',$_REQUEST['page'],'edit',$item->ID),
      'delete'  => sprintf('<a href="?page=%s&action=%s&item=%s">Delete</a>',$_REQUEST['page'],'delete',$item->ID)
    );

    return sprintf('%1$s %2$s',
      /*%1$s*/ $item->linkName,
      /*%2$s*/ $this->row_actions($actions)
    );
  }

  function column_cb($item){
    return sprintf(
      '<input type="checkbox" name="%1$s[]" value="%2$s" />',
      /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
      /*$2%s*/ $item->linkid                //The value of the checkbox should be the record's id
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

  function get_sortable_columns() {
    $sortable_columns = array(
      'date'  => array('date',false),
      'title' => array('title',false)
    );
    return $sortable_columns;
  }

  function column_align($name) {
    $columns = array(
      'date' => 'updateTime',
      'title' => 'linkName'
    );

    return $columns[$name];
  }


  function get_bulk_actions() {
    $actions = array(
      'delete'    => 'Delete'
    );
    return $actions;
  }

  function process_bulk_action() {
    global $wpdb;
    $table_name = $wpdb->prefix.'italm';

    //Detect when a bulk action is being triggered...
    if( 'delete'===$this->current_action() ) {
      $item_ids = implode(',',$_POST['item']);

      if(is_array($_POST['item'])) {
        $sql = "DELETE FROM $table_name WHERE linkid IN($item_ids)";
        $deleted = $wpdb->query( $wpdb->prepare($sql) );
        if($deleted) {
          ?><div class="updated"><p><?php echo $deleted ?> items deleted.</p></div><?php
        }
      }
      else {
        wp_die('Items deleted (or they would be if we had items to delete)!');
      }
    }
  }

  function no_items() {
    _e("No iTunes media items found");
  }

  function prepare_items() {
    global $wpdb;

    $per_page = $this->get_items_per_page('ita_per_page', 10);
    $columns = $this->get_columns();
    $table_name = $wpdb->prefix.'italm';

    $orderby = ( ! empty( $_GET['orderby'] ) ) ? $this->column_align($_GET['orderby']) : 'updateTime';
    $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'desc';

    $this->_column_headers = $this->get_column_info();

    $this->process_bulk_action();

    $current_page = $this->get_pagenum();
    $page_limit = ($current_page-1)*$per_page;

    $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM ".$table_name);
    $this->items = $wpdb->get_results('SELECT * FROM '.$table_name.' ORDER BY '.$orderby.' '.$order.' LIMIT '.$page_limit.','.$per_page,OBJECT );

    $this->set_pagination_args(array(
      "total_items" => $total_items,
      "per_page" => $per_page,
      "total_pages" => ceil($total_items/$per_page)
    ));


  }

}
?>