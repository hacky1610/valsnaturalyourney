<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Datastore {
    static $showOrderList = "wcn_showOrderList";
    static $styleList = "sn_style_list";
    static $workflow = "sn_workflow";
    static $orderSaved = "sn_orderSaved";

    private $wpDataStore;

    function __construct($wpDataStore){
        $this->wpDataStore = $wpDataStore;
    }

    public function GetStyleList() {
        return $this->wpDataStore->Get(self::$styleList);
    }

    public function SetStyleList($value) {
        $this->wpDataStore->Set(self::$styleList,$value);
    }

    public function GetShowOrderList() {
        return $this->wpDataStore->Get(self::$showOrderList);
    }

    public function SetShowOrderList($value) {
        $this->wpDataStore->Set(self::$showOrderList,$value);
    }

    public function GetLastOrderSaved() {
        return $this->wpDataStore->Get(self::$orderSaved);
    }

    public function SetLastOrderSaved($value) {
        $this->wpDataStore->Set(self::$orderSaved,$value);
    }

    public function GetWorkflow() {
      return $this->wpDataStore->Get(self::$workflow);
  }

  public function SetWorkflow($value) {
      $this->wpDataStore->Set(self::$workflow,$value);
  }
}

