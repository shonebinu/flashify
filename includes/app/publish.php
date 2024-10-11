<?php

function publishDeck($user_id, $deck_id, $link_code, $db)
{
  try {
    $db->execute("
    INSERT INTO deck_links (deck_id, generated_by, link_code)
    SELECT :deck_id, :user_id, :link_code
    FROM dual
    WHERE EXISTS (
      SELECT 1
      FROM decks
      WHERE id = :deck_id AND owner = :user_id
    )
  ", [
      "deck_id" => $deck_id,
      "user_id" => $user_id,
      "link_code" => $link_code
    ]);
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function unPublishDeck($user_id, $deck_link_id, $db)
{
  $db->execute(
    "
   DELETE FROM deck_links WHERE id = :deck_link_id AND generated_by = :user_id",
    ["deck_link_id" => $deck_link_id, "user_id" => $user_id]
  );
}

function getPublishedDecks($user_id, $db)
{
  return $db->fetchAll(
    "SELECT deck_links.id, deck_links.link_code, deck_links.generated_by, decks.name, decks.description
     FROM deck_links JOIN decks ON decks.id = deck_links.deck_id WHERE generated_by = :user_id ORDER BY deck_links.created_at DESC",
    ["user_id" => $user_id]
  );
}
