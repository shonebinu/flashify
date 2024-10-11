<?php
function getDecks($user_id, $search_term, $db)
{
  $conditions = ['owner = :user_id'];
  $params = ['user_id' => $user_id];

  if ($search_term) {
    $conditions[] = '(name LIKE :search_term OR description LIKE :search_term)';
    $params['search_term'] = '%' . $search_term . '%';
  }

  $query = "
  SELECT d.id, d.name, d.description, d.is_favorite, d.created_at, COALESCE(c.card_count, 0) as card_count
  FROM decks d
  LEFT JOIN (
      SELECT deck_id, COUNT(*) as card_count
      FROM cards
      GROUP BY deck_id
  ) c ON d.id = c.deck_id
  WHERE " . implode(' AND ', $conditions) . "
  ORDER BY d.is_favorite DESC, d.created_at DESC
  ";

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

function updateDeck($user_id, $deck_id, $deck_name, $deck_description, $deck_fav, $db)
{
  try {
    $db->execute(
      "UPDATE decks SET name=:deck_name, description=:deck_description, is_favorite=:is_favorite WHERE owner=:user_id AND id=:deck_id",
      [
        "deck_id" => $deck_id,
        "deck_name" => $deck_name,
        "deck_description" => $deck_description,
        "is_favorite" => $deck_fav,
        "user_id" => $user_id
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
    "DELETE FROM cards WHERE deck_id=:deck_id",
    ["deck_id" => $deck_id]
  );

  $db->execute(
    "DELETE FROM decks WHERE owner=:user_id AND id=:deck_id",
    [
      "deck_id" => $deck_id,
      "user_id" => $user_id
    ]
  );
}
