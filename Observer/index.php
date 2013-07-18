<?php

interface Observable {
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

interface Observer {
    function update(Observable $observable);
}

abstract class LoginObserver implements Observer {
    private $login;

    function __construct(Login $login) {
        $this->login = $login;
        $login->attach($this);
    }

    function update(Observable $observable) {
        if($observable === $this->login) {
            $this->doUpdate($observable);
        }
    }

    abstract function doUpdate(Login $login);
}

class Login implements Observable {
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS  = 2;
    const LOGIN_ACCESS      = 3;
    private $status = array();
    private $observers;

    function handleLogin($user, $pass, $ip) {
        switch(rand(1,3)) {
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $ret = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $ret = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $ret = false;
                break;
        }
        $this->notify();
        return $ret;
    }
    private function setStatus($status, $user, $ip) {
        $this->status = array($status, $user, $ip);
    }
    function getStatus() {
        return $this->status;
    }

    function attach(Observer $observer){
        $this->observers[] = $observer;
    }
    function detach(Observer $observer){
        $newobservers = array();
        foreach($this->observers as $obs){
            if($obs !== $observer) {
                $newobservers[] = $obs;
            }
        }
        $this->observers = $newobservers;
    }
    function notify(){
        foreach($this->observers as $obs) {
            $obs->update($this);
        }
    }
}

class SecurityMonitor extends LoginObserver {
    function doUpdate(Login $observable) {
        $status = $observable->getStatus();
        if($status[0] == Login::LOGIN_WRONG_PASS) {
            print __CLASS__ . "\t: Письмо администратору\n";
        }
    }
}

class GeneralLogger extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        print __CLASS__ . "\t: Регистрация в журнале\n";
    }
}

class PartnershipTool extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        print __CLASS__ . "\t: Отправка cookie-файла, если адрес соответствует списку\n";
    }
}

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);

$login->handleLogin('test','pass','127.0.0.1');