<?php
function getDecks($user_id, $search_term, $db)
{
  $conditions = ['owner = :user_id'];
  $params = ['user_id' => $user_id];

  if ($search_term) {
    $conditions[] = '(name LIKE :search_term OR description LIKE :search_term)';
    $params['search_term'] = '%' . $search_term . '%';
  }

  $query = "SELECT * FROM decks WHERE " . implode(' AND ', $conditions) . " ORDER BY is_favorite DESC, created_at DESC";

  return $db->fetchAll($query, $params);
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

function deleteDeck($user_id, $deck_id, $db)
{
  $db->execute(
    "DELETE FROM decks WHERE owner=:user_id AND id=:deck_id",
    [
      "deck_id" => $deck_id,
      "user_id" => $user_id
    ]
  );
}
