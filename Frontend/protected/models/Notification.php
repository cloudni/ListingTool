<?php

/**
 * This is the model class for table "{{notification}}".
 *
 * The followings are the available columns in table '{{notification}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $type
 * @property integer $is_viewable
 * @property integer $is_important
 * @property integer $is_new
 * @property integer $company_id
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 */
class Notification extends NIActiveRecord
{
    /**
     * @return string the associated database table name
     */
    const Important_YES=1;
    const Important_NO=0;
    const type_warning=1;
    const type_notification=0;
    /**
     * Get store is active
     * @return array
     */
    public function getIsImportantOptions()
    {
        return array(
            self::Important_YES=>"Yes",
            self::Important_NO=>'No',
        );
    }
    public function getTypeOptions()
    {
        return array(
            self::type_warning=>"Warning",
            self::type_notification=>'Notification',
        );
    }
    public function tableName()
    {
        return '{{notification}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
            array('type, is_viewable, is_important, is_new, company_id, create_time_utc, create_user_id, update_time_utc, update_user_id', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, content, type, is_viewable, is_important, is_new, company_id, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'create_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('models/Notification','ID'),
            'title' => Yii::t('models/Notification','Title'),
            'content' => Yii::t('models/Notification','Content'),
            'type' => Yii::t('models/Notification','Type'),
            'is_viewable' => Yii::t('models/Notification','Is Viewable'),
            'is_important' => Yii::t('models/Notification','Is Important'),
            'is_new' => Yii::t('models/Notification','Is New'),
            'company_id' => Yii::t('models/Notification','Company'),
            'create_time_utc' => Yii::t('models/User','Create Time Utc') ,
            'create_user_id' => Yii::t('models/User','Create User'),
            'update_time_utc' => Yii::t('models/User','Update Time Utc') ,
            'update_user_id' => Yii::t('models/User','Update User'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('type',$this->type);
        $criteria->compare('is_viewable',$this->is_viewable);
        $criteria->compare('is_important',$this->is_important);
        $criteria->compare('is_new',$this->is_new);
        $criteria->compare('company_id',$this->company_id);
        $criteria->compare('create_time_utc',$this->create_time_utc);
        $criteria->compare('create_user_id',$this->create_user_id);
        $criteria->compare('update_time_utc',$this->update_time_utc);
        $criteria->compare('update_user_id',$this->update_user_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notification the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function findByCompanyId()
    {
        $notifications = Notification::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        return $notifications;
    }
}
