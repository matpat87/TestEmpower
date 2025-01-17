<?PHP

class bc_Quote_sugar extends Basic {

    var $new_schema = true;
    var $module_dir = 'bc_Quote';
    var $object_name = 'bc_Quote';
    var $table_name = 'bc_Quote';
    var $importable = false;
    var $disable_row_level_security = true; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;

    function __construct(){
        parent::__construct();
    }

    function bc_Quote_sugar() {
        self::__construct();
    }

    function bean_implements($interface) {
        switch ($interface) {
            case 'ACL': return true;
        }
        return false;
    }

}

?>
