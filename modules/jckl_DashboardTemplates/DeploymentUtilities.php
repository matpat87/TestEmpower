<?php


    /**
     * Used to aid in Template Deployment
     *
     * Class jckl_DashboardTemplatesDeploymentUtilities
     */
    class jckl_DashboardTemplatesDeploymentUtilities
    {

        /**
         * Return the options in step two depending on what the user selected in step one
         * @param $type
         * @return array
         */
        public function getDeployType($type)
        {

            switch ($type) {
                case 'role':
                    $list = $this->getRoles();
                    break;
                case 'group':
                    $list = $this->getGroups();
                    break;
                case 'users':
                    $list = $this->getUsers();
                    break;
            }


            return $list;
        }


        /**
         * Get list of Available roles
         * @return array
         */
        public function getRoles()
        {

            global $db;

            $sql = "SELECT ar.id, ar.name 
                    FROM acl_roles ar
                    WHERE ar.deleted = 0
                    AND ar.id IN (
                      SELECT aru.role_id FROM acl_roles_users aru 
                      WHERE aru.deleted = 0
                      )";

            $GLOBALS['log']->debug('Dashlet Deploy Get Roles Query: ' . $sql);

            $result = $db->query($sql);

            $select_options = array();

                while ($row = $db->fetchByAssoc($result)) {
                    $select_options[$row['id']] = $row['name'];
                }

            return $select_options;

        }

        /**
         * Get list of groups. We aren't using the Security Groups object::getAllGroups
         * because we only want groups with users assigned to them
         */
        public function getGroups()
        {

            global $db;

            $sql = "SELECT sg.id, sg.name
                        FROM securitygroups sg
                        WHERE sg.id IN 
                          (SELECT su.securitygroup_id FROM securitygroups_users su WHERE su.deleted = 0)";

            $GLOBALS['log']->debug('Dashlet Deploy Get Roles Query: ' . $sql);
            $result = $db->query($sql);

            $select_options = array();

                while ($row = $db->fetchByAssoc($result)) {

                    $select_options[$row['id']] = $row['name'];

                }

            return $select_options;

        }


        public function getUsers()
        {

            require_once('modules/Users/User.php');

            $users = User::getAllUsers();

            return $users;
        }


        /**
         * @return mixed
         */
        public function getDeploymentOptions()
        {
            global $app_list_strings;
            return $app_list_strings['jckl_deploy_options'];

        }



    }