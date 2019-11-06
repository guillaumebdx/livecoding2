<?php


namespace App\Model;


class FavoriteManager extends AbstractManager
{
    const TABLE = 'favorite';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $favorite
     * @return int
     */
    public function insert(array $favoriteData)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`item_id`, `user_id`) VALUES (:itemId, :userId )");
        $statement->bindValue('itemId', $favoriteData['itemId'], \PDO::PARAM_INT);
        $statement->bindValue('userId', $favoriteData['userId'], \PDO::PARAM_INT);

        $statement->execute();
    }
}