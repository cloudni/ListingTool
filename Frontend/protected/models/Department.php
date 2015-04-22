<?php

/**
 * This is the model class for table "{{department}}".
 *
 * The followings are the available columns in table '{{department}}':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $company_id
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property User[] $users
 */
class Department extends NIActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public $userId;
    public $removeId;
    public function tableName()
    {
        return '{{department}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('parent_id, company_id, create_time_utc, create_user_id, update_time_utc, update_user_id', 'numerical', 'integerOnly'=>true),
            array('name, note', 'length', 'max'=>256),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, parent_id, company_id, create_time_utc, create_user_id, update_time_utc, update_user_id, note', 'safe', 'on'=>'search'),
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
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'users' => array(self::HAS_MANY, 'User', 'department_id'),
            'parentDepartment' => array(self::BELONGS_TO, 'Department', 'parent_id'),
            'subDepartment' => array(self::HAS_MANY, 'Department', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('models/Department','ID'),
            'name' => Yii::t('models/Department','Name'),
            'parent_id' => Yii::t('models/Department','Parent'),
            'company_id' => Yii::t('models/Department','Company'),
            'create_time_utc' => Yii::t('models/Department','Create Time Utc') ,
            'create_user_id' => Yii::t('models/Department','Create User'),
            'update_time_utc' => Yii::t('models/Department','Update Time Utc') ,
            'update_user_id' => Yii::t('models/Department','Update User') ,
            'note' => Yii::t('models/Department','Note'),
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
        $criteria->compare('name',$this->name,true);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('company_id',$this->company_id);
        $criteria->compare('create_time_utc',$this->create_time_utc);
        $criteria->compare('create_user_id',$this->create_user_id);
        $criteria->compare('update_time_utc',$this->update_time_utc);
        $criteria->compare('update_user_id',$this->update_user_id);
        $criteria->compare('note',$this->note,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Department the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function getAllDepartment()
    {
        $departments = Department::model()->find("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        $result = array();
        if(!empty($department))
            foreach($departments as $department)
            {
                $result[$department->id] = array(
                    'id' => $department->id,
                    'name' => $department->name,
                    'parent_id' => $department->parent_id,
                );
            }

        return $result;
    }

    /**
     * @param bool $start
     * @return string get cascaded folder name for drop down list
     */
    public function getCascadeDepartmentNameRec($start=true)
    {
        if(isset($this->parentDepartment))
        {
            if($start)
                return $this->parentDepartment->getCascadeDepartmentNameRec(false).'- - '.$this->name;
            else
                return $this->parentDepartment->getCascadeDepartmentNameRec(false).'- - ';
        }
        else
        {
            if($start)
                return $this->name;
            else
                return '| ';
        }
    }
    public function register($arr)
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
            //create admin
            if(!$this->save(false))
            {
                $transaction->rollback();
                return false;
            }
            $arrays= explode(",",$arr['userId']);
            $removeArrays= explode(",",$arr['removeId']);
            if(count($removeArrays)>0)
            {
                for($y=0;$y<count($removeArrays)-1;$y++)
                {
                    if($removeArrays[$y])
                    {
                        $user= User::model()->findByPk($removeArrays[$y]);
                        $user->department_id=null;
                        $user->save(true, array('department_id'));
                    }
                }
            }
            if(count($arrays)>0)
            {
                for($x=0;$x<count($arrays)-1;$x++)
                {
                    if($arrays[$x])
                    {
                        $user= User::model()->findByPk($arrays[$x]);
                        $user->department_id=$this->id;
                        $user->save(true, array('department_id'));
                    }
                }
            }
            //create default product folder
            $transaction->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            return false;
        }
    }
}
