<?php

function verify_paytm_txn($paytm_txn_id, $paytm_txn_amount){
    
    $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
    $username = ''; // your paytm registerd email address
    $password = ''; // your mail password

    $user_txn_id = "Order ID: ".$paytm_txn_id;
    $user_txn_amount = 'Rs. '.$paytm_txn_amount;

    $is_found = "No";

    $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());


    $emails = imap_search($inbox, 'TEXT "'.$user_txn_id.'"');

    if(! empty($emails)){
        
        if(count($emails) == 1){
            foreach($emails as $email_number) {
                    
                $overview = imap_fetch_overview($inbox,$email_number,0);
                $email_subject = $overview[0]->subject;
                
                $header = imap_headerinfo($inbox, $email_number);
                $fromaddr = $header->from[0]->mailbox . "@" . $header->from[0]->host;
                
                if (strpos($email_subject, $user_txn_amount) !== false && $fromaddr == 'no-reply@paytm.com') {
                    $is_found = "YES";
                }
            }
        }
    }
    imap_close($inbox);
    return $is_found;
}



?>