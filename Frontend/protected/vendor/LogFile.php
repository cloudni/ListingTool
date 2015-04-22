<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 15-1-15
 * Time: 10:59am
 */

class LogFile
{
    protected $logPath;
    protected $logFilename;

    public static function saveLogFile($fileName='', $path='', $content='')
    {
        $Handle = fopen($path.DIRECTORY_SEPARATOR.$fileName, 'w');
        if(!$Handle) return false;

        try
        {
            fwrite($Handle, $content);
            fclose($Handle);
        }
        catch(Exception $ex)
        {
            if($Handle) fclose($Handle);
        }
    }

    public function __construct($logPath, $logFilename)
    {
        //parent::__construct();
        $this->logPath = $logPath;
        $this->logFilename = $logFilename;
    }

    public function saveOutputToFile()
    {
        if(empty($this->logPath) || empty($this->logFilename)) return false;
        ob_start(array($this, 'stdoutHandler'));
    }

    protected function stdoutHandler($content)
    {
        file_put_contents($this->logPath . DIRECTORY_SEPARATOR . $this->logFilename, $content, FILE_APPEND);
    }
} 