<?php

namespace Sipay;

class Logger
{
    /**
     * Describes log levels.
     */
    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const CRITICAL  = 'critical';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const INFO      = 'info';
    const DEBUG     = 'debug';

    /**
     * Log Levels
     * @var array
     */
    protected static $levels = array(
        self::EMERGENCY => 0,
        self::ALERT     => 1,
        self::CRITICAL  => 2,
        self::ERROR     => 3,
        self::WARNING   => 4,
        self::NOTICE    => 5,
        self::INFO      => 6,
        self::DEBUG     => 7
    );

    protected $threshold;

    protected $uuid;

    protected $folder;
    protected $file;

    private $permissions = 0775;

    protected $options;

    public function __construct($options)
    {
        $this->uuid = md5(microtime(true));

        $path = $options['path'];
        if($path === '') throw new Exception("Empty path");

        if($path[0] !== DIRECTORY_SEPARATOR || preg_match('~\A[A-Z]:(?![^/\\\\])~i',$path) > 0){
            $options['path'] = sipay_sdk_root_path($options['path']);
        }
        var_dump($options['path']);

        $this->setup($options);
    }

    public function setup($options)
    {
        $this->options = $options;

        $this->threshold = static::$levels[$this->options['level']];

        if(!is_dir($this->options['path'])) {
            mkdir($this->options['path'], $this->permissions, true);
        }

        $path = realpath($this->options['path']);

        $this->folder = $path;
        $this->file = $path . DIRECTORY_SEPARATOR . $this->options['prefix'] . date('Ymd') . '.' . $this->options['extension'];
    }

    protected function write($string)
    {
        $handle = fopen($this->file, 'a');

        fwrite($handle, $string);
        fclose($handle);

        $this->flush();
    }

    protected function flush()
    {
        if($handle = opendir($this->folder)) {
            $logs = array();

            $extension = preg_quote($this->options['extension']);
            $prefix = preg_quote($this->options['prefix']);

            $pattern = '/'.$prefix.'([0-9]{8})\.'.$extension.'/';

            while (false !== ($entry = readdir($handle))) {
                if (preg_match($pattern, $entry, $matches) == 1) {
                    $logs[] = array('file' => $this->folder . DIRECTORY_SEPARATOR . $entry, 'date' => $matches[1]);
                }
            }

            usort($logs, function($a, $b) {return ($a['date'] < $b['date']) ? -1 : 1;});

            $delete = (count($logs) > $this->options['backup_file_rotation']) ? count($logs) - $this->options['backup_file_rotation'] : 0;

            for($i = 0; $delete > $i; $i++) {
                @unlink($logs[$i]['backup_file_rotation']);
            }
        }
    }

    public function timestamp()
    {
        return date($this->options['date_format']);
    }

    protected function encode(array $params)
    {
        $string = '';

        foreach($params as $key => $value) {
            if(is_array($value)) {
                $value = "{".$this->encode($value)."}";
            }

            $string .= "$key=$value; ";
        }

        return $string;
    }

    protected function log($level, $origin, $type, $code, $detail, array $params = array())
    {
        $level = strtoupper($level);

        $date = $this->timestamp();
        $uuid = $this->uuid;

        $default = array();

        $params = trim($this->encode(array_merge($default, $this->camouflage($params))));

        $string = "$date - $origin - $level - uuid=$uuid; type=$type; code=$code; detail=$detail; $params".PHP_EOL;

        return $this->write($string);
    }

    protected function camouflage(array $params)
    {
        if(isset($params['pan'])) {
            $params['pan'] = substr($params['pan'], 0, 4).' '.substr($params['pan'], 4, 2).'** **** '.substr($params['pan'], 12);
        }

        if(isset($params['cvv'])) {
            unset($params['cvv']);
        }

        if(isset($params['cardindex'])) {
            $params['cardindex'] = substr($params['cardindex'], 0, 2).'**'.substr($params['cardindex'], -2);
        }

        return $params;
    }

    public function debug($origin, $type, $code, $detail, array $params = array())
    {
        if($this->register(self::DEBUG)) {
            $this->log(self::DEBUG, $origin, $type, $code, $detail, $params);
        }
    }

    public function info($origin, $type, $code, $detail, array $params = array())
    {
        if($this->register(self::INFO)) {
            $this->log(self::INFO, $origin, $type, $code, $detail, $params);
        }
    }

    public function warning($origin, $type, $code, $detail, array $params = array())
    {
        if($this->register(self::WARNING)) {
            $this->log(self::WARNING, $origin, $type, $code, $detail, $params);
        }
    }

    public function error($origin, $type, $code, $detail, array $params = array())
    {
        if($this->register(self::ERROR)) {
            $this->log(self::ERROR, $origin, $type, $code, $detail, $params);
        }
    }

    public function register($level)
    {
        return (static::$levels[$level] <= $this->threshold);
    }
}
