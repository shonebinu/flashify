<?php
function getCards($deck_id, $db)
{
  return $db->fetchAll(
    "SELECT * FROM cards WHERE deck_id=:deck_id",
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
