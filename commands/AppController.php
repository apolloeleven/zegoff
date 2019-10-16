<?php
/**
 * User: zura
 * Date: 16.10.19
 * Time: 12:42
 */

namespace app\commands;


use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class AppController
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package app\commands
 */
class AppController extends Controller
{
    /** @var array */
    public $generateKeysPaths = [
        '@app/.env'
    ];

    /**
     * Sets given keys to .env file
     */
    public function actionSetKeys()
    {
        $this->setKeys($this->generateKeysPaths);
    }

    /**
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionSetup()
    {
        $this->runAction('set-keys', ['interactive' => $this->interactive]);
        Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
        Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);
    }

    /**
     * @param $paths
     */
    private function setKeys($paths)
    {
        foreach ($paths as $file) {
            $file = Yii::getAlias($file);
            Console::output("Generating keys in {$file}");
            $content = file_get_contents($file);
            $content = preg_replace_callback('/<generated_key>/', function () {
                $length = 32;
                $bytes = openssl_random_pseudo_bytes(32, $cryptoStrong);

                return strtr(substr(base64_encode($bytes), 0, $length), '+/', '_-');
            }, $content);
            file_put_contents($file, $content);
        }
    }
}