<?php

require_once ( __DIR__ . "/Baidu-Push-SDK-Php-2.0.4-advanced/Channel.class.php" ) ;

function error_output ( $str )
{
	echo "\033[1;40;31m" . $str ."\033[0m" . "\n";
}

function right_output ( $str )
{
    echo "\033[1;40;32m" . $str ."\033[0m" . "\n";
}

class BaiduPush
{
    protected $ak;
    protected $sk;
    
    protected $channel;
    
    public function __construct($ak, $sk)
    {
        if(empty($ak) || empty($sk)) {
            throw new \InvalidArgumentException("ak and sk must not empty");
        }
        
        $this->ak = $ak;
        $this->sk = $sk;
        $this->channel = new Channel($this->ak, $this->sk);
    }

    public function queryBindList ( $userId, $channelId = null)
    {
        $optional = array();
        
        if($channelId) {
            $optional [ Channel::CHANNEL_ID ] = $channelId;
        }
        
        $ret = $this->channel->queryBindList ( $userId, $optional ) ;
        
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }


    public function verifyBind ( $userId, $channelId = null)
    {
        $optional = array();
        
        if($channelId) {
            $optional[ Channel::CHANNEL_ID ] = $channelId;
        }
        
        $ret = $this->channel->verifyBind ( $userId, $optional ) ;
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    // 推送android设备消息
    public function pushMessageAndroid ($userIdOrTagName, $pushType = 1, $channelId = null)
    {
        
        // 推送消息到某个user，设置push_type = 1;
        // 推送消息到一个tag中的全部user，设置push_type = 2;
        // 推送消息到该app中的全部user，设置push_type = 3;
        $optional = array();

        $pushType = intval($pushType);
        
        switch($pushType) {
            case 2: // 如果推送tag消息，需要指定tagName
                $optional[Channel::TAG_NAME] = $userIdOrTagName;
                break;
            default:                
            case 1: // 推送单播消息，需要指定user
                $optional[Channel::USER_ID] = $userIdOrTagName; 
                if($channelId) {
                    $optional [ Channel::CHANNEL_ID ] = $channelId;
                }
                break;
        }
        
        // 指定发到android设备
        $optional[Channel::DEVICE_TYPE] = 3;
        
        // 指定消息类型为通知
        $optional[Channel::MESSAGE_TYPE] = 1;
        
        // 通知类型的内容必须按指定内容发送，示例如下：
        
        $message = '{
			"title": "test_push",
			"description": "open url",
			"notification_basic_style":7,
			"open_type":1,
			"url":"http://www.baidu.com"
 		}';

        $message_key = "msg_key";
        $ret = $this->channel->pushMessage ( $pushType, $message, $message_key, $optional ) ;
        
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    // 推送ios设备消息
    public function pushMessageIos ($userId)
    {
        $optional = array();
        
        $pushTypeype = 1; //推送单播消息
        $optional[Channel::USER_ID] = $userId; //如果推送单播消息，需要指定user

        // 指定发到ios设备
        $optional[Channel::DEVICE_TYPE] = 4;
        // 指定消息类型为通知
        $optional[Channel::MESSAGE_TYPE] = 1;

        // 如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        // 旧版本曾采用不同的域名区分部署状态，仍然支持。
        $optional[Channel::DEPLOY_STATUS] = 1;
        
        // 通知类型的内容必须按指定内容发送，示例如下：
        $message = '{
		"aps":{
			"alert":"msg from baidu push",
			"sound":"",
			"badge":0
		}
 	    }';
        $message_key = "msg_key";
        $ret = $this->channel->pushMessage ( $pushType, $message, $message_key, $optional ) ;
        
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function fetchMessageCount ( $userId  )
    {
        $ret = $this->channel->fetchMessageCount ( $userId) ;
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function fetchMessage ( $userId  )
    {
        $ret = $this->channel->fetchMessage ( $userId ) ;
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function deleteMessage ( $userId, $msgIds, $channelId = null)
    {
        $optional = array();
        
        if($channelId) {
            $optional[ Channel::CHANNEL_ID ] = $channelId;
        }
        
        $ret = $this->channel->deleteMessage ( $userId, $msgIds, $optional ) ;
        
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }


    public function setTag($tagName, $userId)
    {
        $optional[Channel::USER_ID] = $userId;
        $ret = $this->channel->setTag($tagName, $optional);
        if (false === $ret) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
            return false;
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
            return $ret['response_params']['tid'];
        }
    }

    public function fetchTag($tagName = null)
    {
        $optional = array();
        $optional[Channel::TAG_NAME] = $tagName;
        $ret = $this->channel->fetchTag($optional);
        if (false === $ret) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }

    }


    public function deleteTag($tagName)
    {
        $ret = $this->channel->deleteTag($tagName);
        if (false === $ret) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }

    }


    public function queryUserTags($userId)
    {
        $ret = $this->channel->queryUserTags($userId);
        if (false === $ret) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function initAppIosCert ( $name, $description, $releaseCert, $devCert )
    {
        // 如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        // 旧版本曾采用不同的域名区分部署状态，仍然支持。

        $optional = array();
        $optional[Channel::DEPLOY_STATUS] = 1;

        $ret = $this->channel->initAppIoscert ($name, $description, $releaseCert, $devCert) ;
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function updateAppIosCert ( $name, $description, $releaseCert, $devCert )
    {
        // 如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        // 旧版本曾采用不同的域名区分部署状态，仍然支持。
        $optional = array();        
        $optional[Channel::DEPLOY_STATUS] = 1;
        $optional[ Channel::NAME ] = $name;
        $optional[ Channel::DESCRIPTION ] = $description;
        $optional[ Channel::RELEASE_CERT ] = $releaseCert;
        $optional[ Channel::DEV_CERT ] = $devCert;
        
        $ret = $this->channel->updateAppIoscert ($optional) ;
        
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function queryAppIosCert ( )
    {
        // 如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        // 旧版本曾采用不同的域名区分部署状态，仍然支持。
        $optional = array();
        $optional[Channel::DEPLOY_STATUS] = 1;

        $ret = $this->channel->queryAppIoscert () ;
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }

    public function deleteAppIosCert ( )
    {
        $ret = $this->channel->deleteAppIoscert () ;
        if ( false === $ret ) {
            error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!' ) ;
            error_output ( 'ERROR NUMBER: '  . $this->channel->errno ( ) ) ;
            error_output ( 'ERROR MESSAGE: ' . $this->channel->errmsg ( ) ) ;
            error_output ( 'REQUEST ID: '    . $this->channel->getRequestId ( ) );
        } else {
            right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
            right_output ( 'result: ' . print_r ( $ret, true ) ) ;
        }
    }
}

