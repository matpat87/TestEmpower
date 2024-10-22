<?php
    require_once 'service/v4_1/registry.php';
    class registry_v4_1_custom extends registry_v4_1
    {
        protected function registerFunction()
        {
          parent::registerFunction();

          $this->serviceClass->registerFunction(
            'tr_printout',
            array (
              'session'=>'xsd:string',
              'product_id'=>'xsd:string'
            ),
            array (
              'return'=>'xsd:string'
            )
          );

          $this->serviceClass->registerFunction(
            'auth_with_record_update',
            array (
              'user_credentials' => 'xsd:string',
              'method' => 'xsd:string',
              'record_paramaters' => 'xsd:string',
            ),
            array (
              'return' => 'xsd:string'
            )
          );
          
          $this->serviceClass->registerFunction(
            'update_record_bean',
            array (
              'session' => 'xsd:string',
              'record_paramaters' => 'xsd:string',
            ),
            array (
              'return' => 'xsd:string'
            )
          );
        }
    }