<?php
function getCards($deck_id, $db)
{
  return $db->fetchAll(
    "SELECT id, question, answer, created_at FROM cards WHERE deck_id=:deck_id",
    ["deck_id" => $deck_id]
  );
}

function addCard($deck_id, $card_qn, $card_ans, $db)
{
  $db->execute(
    "INSERT INTO cards (deck_id, question, answer) VALUES(:deck_id, :card_qn, :card_ans)",
    ["deck_id" => $deck_id, "card_qn" => $card_qn, "card_ans" => $card_ans]
  );
}

function updateCard($deck_id, $card_id, $card_qn, $card_ans, $db)
{
  $db->execute(
    "UPDATE cards SET question=:qn, answer=:ans WHERE id=:card_id AND deck_id=:deck_id",
    [
      "deck_id" => $deck_id,
      "card_id" => $card_id,
      "qn" => $card_qn,
      "ans" => $card_ans
    ]
  );
}

function deleteCard($deck_id, $card_id, $db)
{
  $db->execute(
    "DELETE FROM cards WHERE id=:card_id AND deck_id=:deck_id",
    ["card_id" => $card_id, "deck_id" => $deck_id]
  );
}
