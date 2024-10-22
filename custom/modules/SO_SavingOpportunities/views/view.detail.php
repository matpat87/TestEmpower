<?php

require_once 'include/MVC/View/views/view.detail.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SO_SavingOpportunitiesViewDetail extends ViewDetail
{
    public function preDisplay()
    {
        parent::preDisplay();
    }

    public function display()
    {
        $this->bean->amount = NumberHelper::GetCurrencyValue($this->bean->amount);
        $this->bean->previous_price_c = NumberHelper::GetCurrencyValue($this->bean->previous_price_c);
        $this->bean->current_price_c = NumberHelper::GetCurrencyValue($this->bean->current_price_c);
        $this->bean->annual_spend = NumberHelper::GetCurrencyValue($this->bean->annual_spend);
        parent::display();
    }
}