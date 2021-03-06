<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once dirname( __FILE__ ) . '/WoocommerceApiLogic.php';

class WoocommerceApi
{
     /**
     * Logic for Woocommerce 
     *
     * @var WoocommerceApiLogic
     */
    private $woocommerceApiLogic;
    private $wpAdapter; 
    private $dataStore; 
    private $logger; 

    
    function __construct($woocommerceApiLogic,$wpAdapter,$dataStore,$logger){
        $this->woocommerceApiLogic = $woocommerceApiLogic;
        $this->wpAdapter = $wpAdapter;
        $this->dataStore = $dataStore;
        $this->logger = $logger;
        $this->InitAjax();
    }
        
    private function AddAjaxFunction($code, $funcName)
    {
        add_action( 'wp_ajax_nopriv_' . $code, array( $this, $funcName ) );
        add_action( 'wp_ajax_' . $code, array( $this, $funcName ) );
    }
    
    private function InitAjax()
    {
        $this->AddAjaxFunction("get_language","GetLanguageAjax");
        $this->AddAjaxFunction("get_product","GetProductAjax");
        $this->AddAjaxFunction("get_last_orders","GetLastOrdersAjax");
        $this->AddAjaxFunction("get_last_reviews","GetLastReviewsAjax");
        $this->AddAjaxFunction("get_css","GetCssAjax");  
    }

    public function GetLanguageAjax()
    {
        echo  $this->woocommerceApiLogic->GetLanguage($_POST['code']);
        wp_die();
    }


    public function GetProductAjax()
    {
        $prod = $this->woocommerceApiLogic->GetProduct(intval($_POST['id']));
        echo json_encode($prod);
        wp_die();
    }

    public function GetLastOrdersAjax()
    {
        $range = $this->wpAdapter->GetPost('range');
        $this->logger->Info("Range: $range");
        $lastOrderSaved = $this->dataStore->GetLastOrderSaved();
        $orders = null;
        if(!$lastOrderSaved)
        {
            $this->logger->Info("No orders stored");
            $orders = $this->woocommerceApiLogic->GetLastOrders(20);
            $this->dataStore->SetShowOrderList($orders);
            $this->dataStore->SetLastOrderSaved(new DateTime());
        }
        else
        {
            $this->logger->Info("orders stored");
            $now =  new DateTime();

            $diff = abs($now->getTimestamp() - $lastOrderSaved->getTimestamp()) / 60;
            if($diff > 10)
            {
                $this->logger->Info("Older than 10 minutes");

                $orders = $this->woocommerceApiLogic->GetLastOrders(20);
                $this->dataStore->SetShowOrderList($orders);
                $this->dataStore->SetLastOrderSaved(new DateTime());
            }
            else
            {
                $this->logger->Info("Younger than 10 minutes");
                $orders =$this->dataStore->GetShowOrderList(); 
            }
        }

        $currentUserId = get_current_user_id();

        $ordersWithoutCurrentUser = array();
        foreach ($orders as $order)
        {
            if($order->customer_id != $currentUserId)
            {
                array_push($ordersWithoutCurrentUser,$order);
            }
        }
        $ordersWithoutCurrentUser = array_slice($ordersWithoutCurrentUser,0,$range);
        $this->logger->Info($ordersWithoutCurrentUser);
        echo json_encode($orders);

        wp_die();
    }

    public function GetLastReviewsAjax()
    {
        echo json_encode($this->woocommerceApiLogic->GetLastReviews(5));
        wp_die();
    }
    

}
