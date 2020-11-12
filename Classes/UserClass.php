<?
class User{

    public $Id;
    public $Username;
    public $Password;
    public $CreatedAt;
    public $ModifiedAt;
    public $FirstName;
    public $LastName;
    public $Token;
    public $IsActive;

    function Set_Username($usename){
        $this->$Username = $username;
    }

    function Get_Username(){
        return $this->$Username;
    }

    function Set_Password($password){
        $this->$Password = $password;
    }

    function Get_Password(){
        return $this->$Password;
    }

    function Set_CreatedAt(){
        $this->$CreatedAt = date("Y-m-d H:i:s");
    }

    function Get_CeratedAt(){
        return $this->$CreatedAt;
    }

    function Set_ModifiedAt(){
        $this->$ModifiedAt = date("Y-m-d H:i:s");
    }

    function Get_ModifiedAt(){
        return $this->$ModifiedAt;
    }

    function Set_FirstName($firstname){
        $this->$FirstName = $firstname;
    }

    function Get_FirstName(){
        return $this->$FirstName;
    }

    function Set_LastName($lastname){
        $this->$LastName = $lastname;
    }

    function Get_LastName(){
        return $this->$LastName;
    }

    function Set_Token($token){
        $this->$Token = $token;
    }

    function Get_Token(){
        return $this->$Token;
    }

    function Set_IsActive($isActive){
        $this->$IsActive = $isActive;
    }

    function Get_IsActive(){
        return $this->$IsActive;
    }
}
?>