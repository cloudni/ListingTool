<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-9-15
 * Time: 9:57pm
 */

abstract class NIActiveRecord extends CActiveRecord
{

    /**
     * Prepares create_time, create_user_id, update_time and
     * update_user_ id attributes before performing validation.
     */
    protected function beforeValidate()
    {

        if ($this->isNewRecord)
        {
            // set the create date, last updated date
            // and the user doing the creating
            //if(!$this->company_id) $this->company_id = Yii::app()->session['user']->company_id;
            $this->create_time_utc=$this->update_time_utc=time();
            $this->create_user_id = $this->update_user_id = 0;
        }
        else
        {
            //not a new record, so just set the last updated time
            //and last updated user id
            $this->update_time_utc=time();
            $this->update_user_id = 0;

        }
        return parent::beforeValidate();
    }
}