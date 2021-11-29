<?php

class Game extends Db
{
    public static function findAll()
    {
        $request = "SELECT * FROM game";
        $response = self::getDb()->prepare($request);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @var array $data au format ["title" => string , "min_players" => integer,  "max_players" => integer]
     */
    public static function create(array $data)
    {

        $request = "INSERT INTO game(title, min_players, max_players) VALUES (:title, :min_players, :max_players)";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return self::getDb()->lastInsertId();
    }
}
