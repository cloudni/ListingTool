<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/7/11
 * Time: 21:54
 */

class threadCommand extends CConsoleCommand {
    public function run($args)
    {
        $demo = new demo("Page 1", 1);
        $demo->start();

        while(true)
        {
            echo "waiting";
            sleep(5);
        }

        echo "finished\n";
    }
}

class demo extends Thread {
    public $name = '';
    public $param = array();
    public $running = false;

    public function __construct($name, $param) {
        $this->param  = $param;
        $this->name   = $name;
        $this->running = true;
    }

    public function run()
    {
        $yiic='/usr/local/yii/framework/yiic.php';
        $config='/usr/local/apache2/htdocs/html/it/Backend/protected/config/console.php';
        require_once($yiic);
        Yii::createWebApplication($config)->run();
        require_once('/usr/local/apache2/htdocs/html/it/Backend/protected/models/eBayListing.php');

        var_dump(eBayListing::model()->findByPk(100));

        echo "Thread {$this->name} finished.\n";
    }
}