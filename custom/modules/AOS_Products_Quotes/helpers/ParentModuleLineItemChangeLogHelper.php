<?php
class ParentModuleLineItemChangeLogHelper
{
    public static function HandleChangeLogTransactions($bean, $action)
    {
        $parentBeanName = $bean->parent_type !== 'Case' ? $bean->parent_type : 'Cases';
        $parentBean = BeanFactory::getBean($parentBeanName, $bean->parent_id);

        // If no parent bean id exists, do not proceed process
        if (! $parentBean->id) {
            return;
        }

        $auditTableName = "{$parentBean->table_name}_audit";

        // If no audit table exists, do not proceed process
        if (! handleCheckIfTableExists($auditTableName)) {
            return;
        }

        $fieldsToCheck = [];

        switch ($parentBean->module_dir) {
            case 'Cases':
                $fieldsToCheck = [
                    'lot_name', 'customer_product_number',
                    'customer_product_name', 'customer_product_amount_lbs'
                ];
                break;
            default:
                break;
        }

        if (! empty($fieldsToCheck)) {
            self::handleInsertAuditLog($bean, $parentBeanName, $auditTableName, $fieldsToCheck, $action);
        }
    }

    private static function handleInsertAuditLog($lineItemBean, $parentBeanName, $auditTableName, $fieldsToCheck, $action)
    {
        global $dictionary, $current_user, $db;

        foreach ($fieldsToCheck as $field) {
            if ($action == 'insert' && $lineItemBean->fetched_row[$field] == $lineItemBean->$field) {
                continue;
            }

            $newId = create_guid();
            $fieldType = $dictionary[$lineItemBean->module_dir]['fields'][$field]['type'];
            $fieldLabel = translate($dictionary[$lineItemBean->module_dir]['fields'][$field]['vname'], $parentBeanName);
            $afterValueString = $action <> 'delete' ? $lineItemBean->$field : '';

            $db->query("
                INSERT INTO {$auditTableName}
                    (id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string, before_value_text, after_value_text)
                VALUES
                    ('{$newId}', '{$lineItemBean->parent_id}', NOW(), '{$current_user->id}', '[Line Item #{$lineItemBean->number}] {$fieldLabel}', '{$fieldType}', '{$lineItemBean->fetched_row[$field]}', '{$afterValueString}', '', '')
            ");
        }
    }
}