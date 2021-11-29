<?php

class Player extends Db {
    public static function findAll() {
        $request = "SELECT * FROM player";
        $response = self::getDb()->prepare($request);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @var array $data au format ["email" => string , "nickname" => string]
     */
    public static function create(array $data)
    {

        $request = "INSERT INTO player(email, nickname) VALUES (:email, :nickname)";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return self::getDb()->lastInsertId();
    }
}