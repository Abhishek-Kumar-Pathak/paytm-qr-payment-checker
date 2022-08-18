<?php

include_once ('mail.php');

$txnID = $_POST['txn_id'];
$txnAMOUNT = $_POST['txn_amount'];

echo verify_paytm_txn($txnID, $txnAMOUNT);