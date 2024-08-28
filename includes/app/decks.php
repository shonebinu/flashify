<?php
function getDecks($user_id, $db)
{
  $decks = $db->fetchAll("SELECT * FROM decks WHERE owner = :user_id", ['user_id' => $user_id]);

  return $decks;
}


function addDeck($user_id, $deck_name, $deck_description, $deck_fav, $db)
{
  try {
    $db->execute(
      "INSERT INTO decks(owner, name, description, is_favorite) VALUES(:owner, :name, :description, :is_favorite)",
      [
        "owner" => $user_id,
        "name" => $deck_name,
        "description" => $deck_description,
        "is_favorite" => $deck_fav
      ]
    );
    return true;
  } catch (Exception $e) {
    return false;
  }
}
