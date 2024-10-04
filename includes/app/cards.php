<?php
function getCards($deck_id, $user_id, $db)
{
  return $db->fetchAll(
    "SELECT c.id, c.question, c.answer, c.created_at 
         FROM cards c
         JOIN decks d ON c.deck_id = d.id
         WHERE c.deck_id = :deck_id AND d.owner = :user_id",
    ["deck_id" => $deck_id, "user_id" => $user_id]
  );
}

function addCard($deck_id, $card_qn, $card_ans, $user_id, $db)
{
  $deck = $db->fetch(
    "SELECT id FROM decks WHERE id = :deck_id AND owner = :user_id",
    ["deck_id" => $deck_id, "user_id" => $user_id]
  );

  if (!$deck) {
    throw new Exception("Unauthorized: User does not own this deck");
  }

  $db->execute(
    "INSERT INTO cards (deck_id, question, answer) VALUES(:deck_id, :card_qn, :card_ans)",
    ["deck_id" => $deck_id, "card_qn" => $card_qn, "card_ans" => $card_ans]
  );
}

function updateCard($deck_id, $card_id, $card_qn, $card_ans, $user_id, $db)
{
  $db->execute(
    "UPDATE cards c
         JOIN decks d ON c.deck_id = d.id
         SET c.question = :qn, c.answer = :ans 
         WHERE c.id = :card_id AND c.deck_id = :deck_id AND d.owner = :user_id",
    [
      "deck_id" => $deck_id,
      "card_id" => $card_id,
      "qn" => $card_qn,
      "ans" => $card_ans,
      "user_id" => $user_id
    ]
  );
}

function deleteCard($deck_id, $card_id, $user_id, $db)
{
  $db->execute(
    "DELETE c FROM cards c
         JOIN decks d ON c.deck_id = d.id
         WHERE c.id = :card_id AND c.deck_id = :deck_id AND d.owner = :user_id",
    ["card_id" => $card_id, "deck_id" => $deck_id, "user_id" => $user_id]
  );
}
