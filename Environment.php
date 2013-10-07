<?php

/**
 * Description of Environment
 * @author candasm
 * For cli setting example: export YII_APPLICATION_ENV=developement,test,stage,production
 * For WebApp apache virtualHost: SetEnv YII_APPLICATION_ENV "development"  (development,test,stage,production)
 * 
 * why YII_APPLICATION_ENV ? it is just about cli name for not mix with any other variable if you want u can set it
 * 
 * Config files are under protected/config/environment/
 * Config file names starts with webapp,console,test example: webapp.production.php , console.test.php , test.development.php
 * ConfigFile array should have these keys inside it key names are YII_PATH , YIIC_PATH, YII_DEBUG, YII_TRACE_LEVEL if it doesnt have YII_PATH or YIIC_PATH system will give an error!
 * 
 * Pay attention environment config files are merging with standart config files. Environment config files are writing on standart config file so standart config files are just for global settings
 * 
 * TODO write cli version for setup it easy
 * 
 */
class Environment {
    /**
     * @var string This is system variable name if u wanna use different u can change it!
     */

    const APPLICATION_ENV = 'YII_APPLICATION_ENV';

    /**
     * @var string environment config folder under system config
     */
    const ENVIRONMENT_CONFIG_FOLDER = 'environment';

    /**
     * @var string config folder path
     */
    protected $configFolder=null;

    /**
     * @var string its shows for settings webapp,console,test
     */
    protected $app;

    /**
     * @var array supported app names
     */
    private $appNames = array('main', 'test', 'console');

    private $defaultAppName = 'main';

    /**
     * @var array application config
     */
    protected $config = array();

    /**
     * @var string Environment state
     */
    protected $state;
    protected $errors = array(
        'config_file_doesnt_exists' => 'Config file does not exists {path}',
        'important_key_name_not_seted' => 'Important key name "{keyName}" not seted in config file "{configFile}"  ',
        'app_name_is_not_supporting' => 'App name "{appName}" is not supporting!',
    );
    protected $systemConfig = array(
        'YII_TRACE_LEVEL' => FALSE,
        'YII_DEBUG' => FALSE,
        'YII_PATH' => NULL,
        'YIIC_PATH' => NULL,
    );

    /**
     * @param string|NULL $app app type [webapp,console,test] if null default is webapp
     * if YII_APPLICATION_ENV is not seted default is development if there is no config file system will give error!
     */
    public function __construct($app = NULL) {
        $environment = getenv(self::APPLICATION_ENV);
        if (!$environment) {
            $environment = 'development';
        }
        if (is_null($app)) {
            $app = $this->defaultAppName;
        }
        if(is_null($this->configFolder)){
            $this->configFolder = dirname(__FILE__) . '/../../../config/';
        }
        if (!in_array($app, $this->appNames)) {
            echo 'Error: ' . str_replace('{appName}', $app, $this->errors['app_name_is_not_supporting']) . PHP_EOL;
            exit;
        }
        $this->app = $app;
        $this->state = $environment;
        $this->install();
    }

    /**
     * checks files if exists install config file and set config ;
     */
    protected function install() {
        try {
            //set config file
            $configFile = $this->app . '.' . $this->state . '.php';
            $configFileFullPath = $this->configFolder . self::ENVIRONMENT_CONFIG_FOLDER . '/' . $configFile;
            //check config file
            if (!file_exists($configFileFullPath)) {
                throw new Exception(str_replace('{path}', $configFile, $this->errors['config_file_doesnt_exists']));
            }
            //global config file name
            $globalConfigFile = $this->configFolder . $this->app . '.php';

            //get config
            $config = include $configFileFullPath;
            //merge if global config file name exists
            if (file_exists($globalConfigFile)) {
                $config = self::mergeArray(include $globalConfigFile, $config);
            }
            /**
             * if these keys are not exists system will give error!
             */
            $importantKeyNames = array(
                'YII_PATH', 'YIIC_PATH',
            );
            /**
             * theese key names are not necessary but if u set keys will set as defined variable!
             */
            $unimportantKeyNames = array(
                'YII_DEBUG', 'YII_TRACE_LEVEL',
            );
            //check important keys 
            foreach ($importantKeyNames as $name) {
                if (!array_key_exists($name, $config)) {
                    throw new Exception(str_replace(array('{keyName}', '{configFile}'), array($name, $configFile), $this->errors['important_key_name_not_seted']));
                }
                //set 
                $this->systemConfig[$name] = $config[$name];
            }
            //it doesnt important but also check YII_DEBUG , YII_TRACE_LEVEL and define it if itdoesnt defined
            foreach ($unimportantKeyNames as $name => $value) {
                if (array_key_exists($name, $config)) {
                    defined($name) or define($name, $value);
                    //set 
                    $this->systemConfig[$name] = $config[$name];
                }
            }
            //unset YII_TRACE_LEVEL,YII_DEBUG,YII_PATH,YIIC_PATH
            $unsetKeys = array_merge($importantKeyNames, $unimportantKeyNames);
            foreach ($unsetKeys as $name) {
                if (array_key_exists($name, $config)) {
                    unset($config[$name]);
                }
            }
            //set config file!
            $this->config = $config;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            exit;
        }
    }

    /**
     * returns config array
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * returns frameworks yii path
     */
    public function getYiiPath() {
        return $this->systemConfig['YII_PATH'];
    }

    /**
     * returns framework yiic file path
     */
    public function getYiicPath() {
        return $this->systemConfig['YIIC_PATH'];
    }

    public function getState() {
        return $this->state;
    }
    /**
     * @return string Config folder path environment protected/config
     */
    public function getConfigFolder(){
        return $this->configFolder;
    }
    /**
     * sets application config path
     * @param string $configPath application config path
     * 
     */
    public function setConfigFolder($configPath){
        $this->configPath = $configPath;
    }
    /**
     * yiiframework cmap::mergearray function duplicated becaouse of this class starts before framework
     */
    private function mergeArray($a, $b) {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_integer($k))
                    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                elseif (is_array($v) && isset($res[$k]) && is_array($res[$k]))
                    $res[$k] = self::mergeArray($res[$k], $v);
                else
                    $res[$k] = $v;
            }
        }
        return $res;
    }

}