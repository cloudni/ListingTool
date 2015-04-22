<?php

/**
 * Email class.
 */
class Email extends CFormModel
{
    public $title;
    public $purpose;
    public $content;
    public $recipient;
    public $sender;
    public $date;


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
       return array();
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        );
    }
}
