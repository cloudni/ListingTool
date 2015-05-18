<?php

class WishListingController extends Controller
{
	public function actionIndex($currentStatus='All', $currentStore='All')
	{
        if(strtolower($currentStore) != 'all' && $currentStore != (string)(int)$currentStore) $currentStore = 'all';
        if(!isset($currentStatus) || !$currentStatus) $currentStatus = 'all';

        $stores = Store::model()->findAll(
            "company_id=:company_id and platform=:platform and is_active=:is_active",
            array(
                ':company_id' => Yii::app()->session['user']->company_id,
                ':platform'=>Store::PLATFORM_WISH,
                ':is_active'=>Store::ACTIVE_YES,
            )
        );
        if(empty($stores))
        {
            Yii::app()->user->setFlash('Error', 'No active store available, please create or authorize a Wish.com store first!');
            $currentStore = 'All';
        }
        else
        {
            $tempList = array();
            $findStore = false;
            foreach($stores as $row)
            {
                $tempList[$row['id']] = $row['name'];
                if($row['id'] == (int)$currentStore) $findStore = true;
            }
            $stores = $tempList;
            if(!$findStore && strtolower($currentStore) != 'all')
            {
                Yii::app()->user->setFlash('Error', 'The Store you selected does not exist or is not active!');
                $store = 'All';
            }
        }

        $statusSQL = "SELECT distinct review_status FROM lt_wish_listing where company_id=:company_id;";
        $command = Yii::app()->db->createCommand($statusSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $result = $command->queryAll();
        if(empty($result))
            $statusList = array();
        else
            foreach($result as $status) $statusList[$status['review_status']] = $status['review_status'];

        $whereSQL = "";
        if(isset($currentStore) && strtolower($currentStore) != 'all')
        {
            $whereSQL .= " and t.store_id = :store_id ";
        }
        if(isset($currentStatus) && strtolower($currentStatus) != 'all')
        {
            $whereSQL .= " and t.review_status = :review_status ";
        }
        $listingSQL = "SELECT t.*, s.name as storename
                        FROM lt_wish_listing t
                        left join lt_store s on s.id = t.store_id
                        where t.company_id = :company_id and s.is_active = :is_active
                        $whereSQL
                        order by t.id desc;";
        $command = Yii::app()->db->createCommand($listingSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":is_active", Store::ACTIVE_YES, PDO::PARAM_INT);
        if(isset($currentStore) && strtolower($currentStore) != 'all')
        {
            $command->bindValue(":store_id", (int)$currentStore, PDO::PARAM_INT);
        }
        if(isset($currentStatus) && strtolower($currentStatus) != 'all')
        {
            $command->bindValue(":review_status", $currentStatus, PDO::PARAM_STR);
        }
        $rawData=$command->queryAll();
        $dataProvider=new CArrayDataProvider($rawData, array(
            'id'=>'id',
            'sort'=>array(
                'attributes'=>array(
                    //'el.id', 'soldquantity'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));

        $this->layout = '';
		$this->render('index', array(
            'storeList'=>$stores,
            'statusList'=>$statusList,
            'currentStatus'=>$currentStatus,
            'currentStore'=>$currentStore,
            'dataProvider'=>$dataProvider,
        ));
	}

    public function actionSearchAppliedListings($searchKeyword='', $searchStore='all')
    {
        if(isset($_POST['searchKeyword']) && $_POST['searchKeyword']) $searchKeyword = $_POST['searchKeyword'];
        if(isset($_POST['searchStore']) && $_POST['searchStore']) $searchStore = $_POST['searchStore'];

        $whereSQL = "";
        if(isset($searchStore) && $searchStore && strtolower($searchStore) != 'all')
        {
            $whereSQL .= " and t.store_id = :store_id ";
        }
        if(isset($searchKeyword) && $searchKeyword)
        {
            $whereSQL .= " and (t.name like '%$searchKeyword%' or t.wish_id like '%$searchKeyword%') ";
        }
        $sql = "SELECT t.`id`, t.`company_id`, t.`store_id`, t.`wish_id`, t.`main_image`, t.`name`, t.`review_status`, t.`upc`, t.`extra_images`, t.`landing_page_url`, t.`number_saves`, t.`number_sold`, t.`parent_sku`,
                s.name as storename, ".Store::PLATFORM_WISH." as platform
                FROM lt_wish_listing t
                left join lt_store s on s.id = t.store_id
                where t.company_id = :company_id and s.is_active = :is_active and t.review_status = 'approved'
                $whereSQL
                order by t.id desc;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":is_active", Store::ACTIVE_YES, PDO::PARAM_INT);
        if(isset($searchStore) && $searchStore && strtolower($searchStore) != 'all')
        {
            $command->bindValue(":store_id", (int)$searchStore, PDO::PARAM_INT);
        }
        $listings = $command->queryAll();

        $result = array('status'=>'success', 'data'=>$listings);
        echo json_encode($result);
    }

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete, searchAppliedListings', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index', 'searchAppliedListings'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}