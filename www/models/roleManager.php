<?php

require_once APP_PATH . "/models/entities/roleModel.php";
require_once APP_PATH . "/models/entities/PDOServer.php";
class roleManager extends PDOServer
{

    public function getAllRoles()
    {
        $req = $this->db->query("SELECT * FROM role ORDER BY id");
        $datas = $req->fetchAll();
        foreach ($datas as $data) {
            $roles[] = new role($data);
        }
        return $roles;
    }
}
