<?php

namespace filsh\yii2\oauth2server\controllers;

use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use Yii;
use yii\helpers\ArrayHelper;

class RestController extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className(),
            ],
        ]);
    }

    /**
     * Generate Oauth2 token
     *
     * @return mixed
     * @throws \yii\base\InvalidCallException
     *
     * @author Nadeem Akhtar <nadeem@myswich.com>
     *
     */
    public function actionToken()
    {
        // If module not exist throw an exception
        $module = isset(Yii::$app->modules['oauth2']) ? Yii::$app->modules['oauth2'] : null;

        if (!$module) {
            throw new \yii\base\InvalidCallException('Oauth2 is not defined');
        }
        $response = $module->getServer()->handleTokenRequest();

        return $response->getParameters();
    }
}