<?php
function sb_send_email($from, $to, $subject, $message, $attach=Null) {
    $boundary = md5(time());

    $headers = "From: $from";
    $headers .= "\r\nMIME-Version: 1.0";
    $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"";

    $message_body = "This is a multi-part message in MIME format.\r\n";

    $message_body .= "--$boundary\r\n";
    $message_body .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
    $message_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message_body .= $message;

    if ($attach != Null) {
        $attachment_encoded = chunk_split(base64_encode(file_get_contents($attach)));
        $mime_type = mime_content_type($attach);
        $filename = basename($attach);
        $message_body .= "\r\n\r\n--$boundary\r\n";
        $message_body .= "Content-Type: $mime_type; name=\"$filename\"\r\n";
        $message_body .= "Content-Transfer-Encoding: base64\r\n";
        $message_body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
        $message_body .= $attachment_encoded;
    }

    $message_body .= "\r\n\r\n--$boundary--";

    return mail($to, $subject, $message_body, $headers);
}
