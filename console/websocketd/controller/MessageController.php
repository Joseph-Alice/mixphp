<?php

namespace console\websocketd\controller;

use mix\websocket\Controller;
use console\websocketd\model\MessageForm;
use mix\web\Json;

/**
 * 消息控制器
 * @author 刘健 <coder.liu@qq.com>
 */
class MessageController extends Controller
{

    // 加入房间
    public function actionTo($data, $userinfo)
    {
        // 使用模型
        $model             = new MessageForm();
        $model->attributes = $data;
        $model->setScenario('to');
        // 验证失败
        if (!$model->validate()) {
            return null;
        }

        // 通过消息队列给其他用户发消息
        \Mix::app()->redis->publish('emit_to_' . $model->uid, $model->message);
    }

}
