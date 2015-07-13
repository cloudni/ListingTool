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
        $pool = array();
        echo "thread command\n";
        $seed = array();
        for($i=1;$i<=20;$i++) $seed[] = $i;
        $demo = new demo("Page 1", $seed);
        $demo->start();
        $pool[] = $demo;

        sleep(10);

        $seed = array();
        for($i=21;$i<=40;$i++) $seed[] = $i;
        $name = "demo1";
        $$name = new demo("Page 2", $seed);
        $$name->start();
        $pool[] = $$name;

        echo "check...\n";
        while(true)
        {
            $allDone = true;
            foreach ($pool as $key => $thread) {
                if($thread->running) {
                    echo "waiting\n";
                    $allDone = false;
                    break;
                }
            }
            if($allDone) break;
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
        foreach($this->param as $param)
        {
            sleep(2);
            echo "item $param process finished.\n";
        }
        $this->running = false;
        echo "Thread {$this->name} finished, total: ".count($this->param)." items processed.\n";
    }
}