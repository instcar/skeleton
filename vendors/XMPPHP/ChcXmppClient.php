<?php
/**
 *Author : chenhaichao
 *Time   : 2014/05/25
 *Brief  : php xmpp client 
 **/ 

require_once dirname(__FILE__) . "/XMPP.php";

class XMPPHP_ChcXmppClient
{
    protected $host;
    protected $port;
    protected $user;
    protected $pwd;
    protected $domain;
    protected $conn;

    public function init($host, $port, $user, $pwd, $domain)
    {
        try
        {
            $this->host = $host;
            $this->port = $port;
            $this->user = $user;
            $this->pwd = $pwd;
            $this->domain = $domain;

            $conn = new XMPPHP_XMPP($host, $port, $user, $pwd, 'xmpphp', $domain, false, $loglevel=XMPPHP_Log::LEVEL_VERBOSE);
            $conn->connect();
            $conn->processUntil('session_start');
            $conn->presence();

            $this->conn = $conn;
            return true;
        }
        catch (XMPPHP_Exception $e)
        {
            return false;
        }
    }
        
    public function register($new_user, $new_user_pwd)
    {
        try
        {
            $this->conn->registerNewUser($new_user, $new_user_pwd, "", "",  $this->domain);
            return true;
        }
        catch (XMPPHP_Exception $e)
        {
            return false;
        }
    }

    public function createRoom($room_name)
    {
        try
        {
            $this->conn->createRoomEx($room_name, $this->domain);
            return true;
        }
        catch (XMPPPHP_Exception $e)
        {
            return false;
        } 
    }

    public function destroyRoom($room_name)
    {
        try
        {
            $this->conn->destroyRoom($room_name, $this->domain);
            return true;
        }
        catch (XMPPPHP_Exception $e)
        {
            return false;
        } 
    }

    public function messageRoom($room_name, $message)
    {
        try
        {
            $this->conn->messageRoom($room_name, $this->domain, $message);
            return true;
        }
        catch (XMPPHP_Exception $e)
        {
            return false;
        }
    } 
}
