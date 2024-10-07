<?php
function getReviewCard($deck_id, $user_id, $db)
{
  return $db->fetch(
    "SELECT c.id, c.question, c.answer, c.score
         FROM cards c
         JOIN decks d ON c.deck_id = d.id
         WHERE c.deck_id = :deck_id AND d.owner = :user_id ORDER BY c.score ASC LIMIT 1",
    ["deck_id" => $deck_id, "user_id" => $user_id]
  );
}


function updateCardScore($card_id, $new_score, $deck_id, $user_id, $db)
{
  return $db->execute(
    "UPDATE cards c
              JOIN decks d ON c.deck_id = d.id
              SET c.score = :score
              WHERE c.id = :card_id
              AND c.deck_id = :deck_id
              AND d.owner = :user_id",
    [
      ':score' => $new_score,
      ':card_id' => $card_id,
      ':deck_id' => $deck_id,
      ':user_id' => $user_id
    ]
  );
}
