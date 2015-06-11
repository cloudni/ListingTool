<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/5/13
 * Time: 21:08
 */
Yii::import('application.vendor.Wish.*');
require_once("WishClient.php");

class WishAPI {
    public static function GetAllProducts($store_id, $params=array())
    {
        if(!isset($store_id) || !$store_id)
        {
            echo "Invalid Store information.\n";
            return false;
        }

        $store = Store::model()->findByPk($store_id);
        if(empty($store))
        {
            echo "can not find store.\n";
            return false;
        }
        if($store->is_active != Store::ACTIVE_YES || !$store->wish_token)
        {
            echo "wish token is invalid or store is in-active.\n";
            return false;
        }

        echo date("Y-m-d H:i:s", time())."start to download Wish.com product for store, id: ".$store->id.", name: ".$store->name."\n";

        try
        {
            $client = new WishClient($store->wish_token);
            $products = $client->getAllProducts();
            if(count($products) > 0) foreach($products as $prod)
            {
                $prod = $prod->Product;
                $wishProd = WishListing::model()->find("wish_id=:id and company_id=:company_id", array(
                    ':id'=>(string)$prod->id,
                    ':company_id'=>$store->company_id,
                ));
                if(empty($wishProd)) $wishProd = new WishListing();
                $wishProd->company_id = $store->company_id;
                $wishProd->wish_id = (string)$prod->id;
                $wishProd->store_id = $store->id;
                $wishProd->main_image = isset($prod->main_image) ? (string)$prod->main_image : '';
                $wishProd->description = isset($prod->description) ? (string)$prod->description : '';
                $wishProd->name = isset($prod->name) ? (string)$prod->name : '';
                $wishProd->review_status = isset($prod->review_status) ? (string)$prod->review_status: '';
                $wishProd->upc = isset($prod->upc) ? (string)$prod->upc : '';
                $wishProd->extra_images = isset($prod->extra_images) ? (string)$prod->extra_images: '';
                $wishProd->landing_page_url = isset($prod->landing_page_url) ? (string)$prod->landing_page_url : '';
                $wishProd->number_saves = isset($prod->number_saves) ? (int)$prod->number_saves : 0;
                $wishProd->number_sold = isset($prod->number_sold) ? (int)$prod->number_sold : 0;
                $wishProd->parent_sku = isset($prod->parent_sku) ? (string)$prod->parent_sku : '';
                $wishProd->save(false);
                echo "product {$wishProd->wish_id} has been processed.\n";
            }
        }
        catch(Exception $ex)
        {
            echo "exception happened, Code: ".$ex->getCode().", Msg: ".$ex->getMessage().".\n";
            return false;
        }

        echo "Get all products finished.\n";
        return true;
    }

    public static function GetProductById($id=null)
    {
        if(!isset($id) || empty($id)) return false;

        $wishProd = WishListing::model()->find("wish_id=:wish_id", array(":wish_id"=>$id));
        if(empty($wishProd)) return false;

        $client = new WishClient($wishProd->store->wish_token);
        $prod = $client->getProductById($id);var_dump($prod);
        $wishProd->main_image = isset($prod->main_image) ? (string)$prod->main_image : '';
        $wishProd->description = isset($prod->description) ? (string)$prod->description : '';
        $wishProd->name = isset($prod->name) ? (string)$prod->name : '';
        $wishProd->review_status = isset($prod->review_status) ? (string)$prod->review_status: '';
        $wishProd->upc = isset($prod->upc) ? (string)$prod->upc : '';
        $wishProd->extra_images = isset($prod->extra_images) ? (string)$prod->extra_images: '';
        $wishProd->landing_page_url = isset($prod->landing_page_url) ? (string)$prod->landing_page_url : '';
        $wishProd->number_saves = isset($prod->number_saves) ? (int)$prod->number_saves : 0;
        $wishProd->number_sold = isset($prod->number_sold) ? (int)$prod->number_sold : 0;
        $wishProd->parent_sku = isset($prod->parent_sku) ? (string)$prod->parent_sku : '';
        $wishProd->save(false);
        echo "product {$wishProd->wish_id} has been processed.\n";
    }
}