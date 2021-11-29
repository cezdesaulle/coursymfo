<?php

class    Contest extends Db
{
    public static function findAll()
    {
        $request = "SELECT contest.id, game.title, count(player_contest.player_id) as nbPlayers, winner.nickname, contest.start_date
                    FROM contest
                    LEFT JOIN player_contest ON contest.id = player_contest.contest_id
                    LEFT JOIN player ON player_contest.player_id = player.id
                    INNER JOIN game ON contest.game_id = game.id
                    LEFT JOIN player as winner ON contest.winner_id = winner.id
                    GROUP BY contest.id
                    ORDER BY contest.start_date DESC";
        $response = self::getDb()->prepare($request);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findOne(int $id)
    {
        $request = "SELECT contest.id, game.title, game.min_players, game.max_players, count(player_contest.player_id) as nbPlayers, winner.nickname, winner.id as winnerId, contest.start_date
                    FROM contest
                    LEFT JOIN player_contest ON contest.id = player_contest.contest_id
                    LEFT JOIN player ON player_contest.player_id = player.id
                    INNER JOIN game ON contest.game_id = game.id
                    LEFT JOIN player as winner ON contest.winner_id = winner.id
                    WHERE contest.id = :id
                    GROUP BY contest.id
                    ";
        $response = self::getDb()->prepare($request);
        $response->execute(['id' => $id]);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function getPlayers(int $id)
    {
        $request = "SELECT player.id, player.nickname, player.email
                    FROM contest
                    INNER JOIN player_contest ON contest.id = player_contest.contest_id
                    INNER JOIN player ON player_contest.player_id = player.id
                    WHERE contest.id = :id
                    ";
        $response = self::getDb()->prepare($request);
        $response->execute(['id' => $id]);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findNotRegisteredPlayers(int $id)
    {
        $request = "SELECT *
                    FROM player
                    WHERE id NOT IN (
                        SELECT player.id
                        FROM contest
                        INNER JOIN player_contest ON contest.id = player_contest.contest_id
                        INNER JOIN player ON player_contest.player_id = player.id
                        WHERE contest.id = :id
                    )
                    ";
        $response = self::getDb()->prepare($request);
        $response->execute(['id' => $id]);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addPlayer(int $contestId, int $playerId)
    {
        $request = "INSERT INTO player_contest(player_id, contest_id) VALUES (:player_id, :contest_id)";
        $response = self::getDb()->prepare($request);
        $response->execute([
            'player_id' => $playerId,
            'contest_id' => $contestId
        ]);

        return self::getDb()->lastInsertId();
    }

    public static function removePlayer(int $contestId, int $playerId)
    {
        $request = "DELETE FROM player_contest WHERE player_id = :player_id AND contest_id = :contest_id";
        $response = self::getDb()->prepare($request);
        $response->execute([
            'player_id' => $playerId,
            'contest_id' => $contestId
        ]);

        return self::getDb()->lastInsertId();
    }

    public static function setWinner(int $contestId, int $playerId)
    {

        $request = "UPDATE contest SET winner_id = :winner_id WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute([
            'winner_id' => $playerId,
            'id' => $contestId
        ]);

        return self::getDb()->lastInsertId();
    }

    /**
     * @var array $data au format ["game_id" => string , "start_date" => string]
     */
    public static function create(array $data) {

        $request = "INSERT INTO contest(game_id, start_date) VALUES (:game_id, :start_date)";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return self::getDb()->lastInsertId();

    }
}
