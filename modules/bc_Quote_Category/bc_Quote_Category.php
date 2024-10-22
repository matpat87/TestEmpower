<?PHP

require_once('modules/bc_Quote_Category/bc_Quote_Category_sugar.php');

class bc_Quote_Category extends bc_Quote_Category_sugar {

    function bc_Quote_Category() {
        parent::bc_Quote_Category_sugar();
    }

    function create_new_list_query($order_by, $where, $filter = array(), $params = array(), $show_deleted = 0, $join_type = '', $return_array = false, $parentbean = null, $singleSelect = false, $ifListForExport = false) {
        $query = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);
        $query = str_replace('bc_quote_category', 'bc_Quote_Category', $query);
        return $query;
    }

}

?>
