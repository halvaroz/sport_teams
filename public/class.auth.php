<?php 
class Auth{
    
    var $forbiddenPage = "forbidden.php";
    /**
     * Permet d'identifier un utilisateur
     **/
    function login($d){
        $pdo = get_pdo();
        $req = $pdo->prepare('SELECT sn_users.id,sn_users.login,sn_users.address,sn_roles.name,sn_roles.role,sn_roles.level  FROM sn_users LEFT JOIN sn_roles ON sn_users.role_id=sn_roles.id WHERE login=:login AND password=:password');
        $req->execute($d); 
        $data = $req->fetchAll();
        if(count($data)>0){
                $_SESSION['Auth'] = $data[0]; 
                return true;
        }
        return false; 
    }
    /**
     * Autorise un rang à accéder à une page, redirige vers forbidden sinon
     * */
    function allow($rang){
        $pdo = get_pdo();
        $req = $pdo->prepare('SELECT role,level  FROM sn_roles');
        $req->execute(); 
        $data = $req->fetchAll();
        $roles = array(); 

        foreach($data as $d){
            $roles[$d['role']] = $d['level']; 
        }

        
        if(!$this->user('role')){
            $this->forbidden(); 
        }else{
            if($roles[$rang] > $this->user('level')){
                $this->forbidden(); 
            }else{
                return true;
            }
        }
    }
    
    /**
     * Récupère une info utilisateur
     ***/
    function user($field){

        if(isset($_SESSION['Auth'][$field])){
            return $_SESSION['Auth'][$field];
        } else{
            return false; 
        }
    }
    /**
     * Redirige un utilisateur
     * */
    function forbidden(){
        header('Location:'.$this->forbiddenPage);
    }
}

$Auth = new Auth();
