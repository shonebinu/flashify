<?php

function getAllPublishedDecks($search_term, $db)
{
  $conditions = [];
  $params = [];

  if ($search_term) {
    $conditions[] = '(d.name LIKE :search_term OR d.description LIKE :search_term OR u.name LIKE :search_term OR dl.link_code LIKE :search_term)';
    $params['search_term'] = '%' . $search_term . '%';
  }

  $query = "
    SELECT 
      dl.link_code, 
      d.name AS deck_name, 
      d.description AS deck_description, 
      u.name AS user_name, 
      COUNT(c.id) AS card_count
    FROM 
      deck_links AS dl
    JOIN 
      decks AS d ON d.id = dl.deck_id
    JOIN 
      users AS u ON dl.generated_by = u.id
    LEFT JOIN 
      cards AS c ON d.id = c.deck_id
    ";

  if ($conditions) {
    $query .= " WHERE " . implode(' AND ', $conditions);
  }

  $query .= " GROUP BY dl.link_code, d.name, d.description, u.name;";

  return $db->fetchAll($query, $params);
}

function getCardsFromDeckCode($link_code, $db)
{
  $query = "SELECT * FROM cards WHERE deck_id = (SELECT deck_id FROM deck_links WHERE link_code = :link_code)";
  return $db->fetchAll($query, ["link_code" => $link_code]);
}

function cloneDeck($link_code, $user_id, $deck_name, $deck_description, $db)
{
  $db->execute(
    "INSERT INTO decks(owner, name, description) VALUES(:owner, :name, :description)",
    [
      "owner" => $user_id,
      "name" => $deck_name,
      "description" => $deck_description,
    ]
  );

  $new_deck_id = $db->lastInsertId();
  $cards = getCardsFromDeckCode($link_code, $db);

  if (!empty($cards)) {
    $placeholders = [];
    $values = [];

    foreach ($cards as $index => $card) {
      $placeholderIndex = $index * 3;
      $placeholders[] = "(:deck_id{$placeholderIndex}, :card_qn{$placeholderIndex}, :card_ans{$placeholderIndex})";

      $values["deck_id{$placeholderIndex}"] = $new_deck_id;
      $values["card_qn{$placeholderIndex}"] = $card['question'];
      $values["card_ans{$placeholderIndex}"] = $card['answer'];
    }

    $sql = "INSERT INTO cards (deck_id, question, answer) VALUES " . implode(', ', $placeholders);
    $db->execute($sql, $values);
  }

  return $new_deck_id;
}
