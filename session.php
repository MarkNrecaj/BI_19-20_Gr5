<?php class Session
{
    private $id;
    private $expire;
    private $is_login;
    public function __construct()
    {
        $this->id = 0;
        $this->is_login = false;
        $this->expire = false;
    }
    function isLogin()
    {
        if (isset($_COOKIE['is_login']) && $_COOKIE['is_login']) {
            $this->is_login = true;
        }
        return $this->is_login;
    }

    function idExpire()
    {
        if (isset($_SESSION['expire']) && (time() - $_SESSION['expire']) > 0) {
            $this->expire  = true;
        }
        return $this->expire;
    }
    function getId()
    {
        $this->id = 0;
        if (isset($_SESSION['id'])) {
            $this->id = (int) $_SESSION['id'];
        }
        return $this->id;
    }

    function setId($id)
    {
        $_SESSION['id'] = $id;
        $_SESSION['start'] = time();
        $this->id = (int) $_SESSION['id'];
    }
    function setExpire($time)
    {
        $_SESSION['expire'] = $_SESSION['start']  + $time;
        $this->expire  = $time > 0 ? true : false;
    }
    function setIsLogin($is_login)
    {
        setcookie("is_login", $is_login, time() + 3600);
        $this->is_login = $is_login;
    }
}
