<?php
function sb_validate_s3($destination, $close=true) {
    S3::setExceptions();
    $s3 = new S3($destination['access_key_id'], $destination['access_key_secret']);

    try {
        $bucket_info = $s3->getBucket($destination['bucket']);
    } catch (S3Exception $s3e) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/S3_CONNECT_FAILED'), array($destination['name'], $s3e->getMessage()));
        sb_log_error(i18n_r(SB_SHORTNAME.'/S3_CONNECT_FAILED'), array($destination['name'], $s3e->getMessage()));
        sb_log_error($s3e->getMessage());
        return false;
    }

    if ($close) {
        return true;
    }
    return $s3;
}

function sb_upload_s3($archive, $destination) {
    $s3 = sb_validate_s3($destination, false);
    if (!$s3) {
        return false;
    }

    try {
        $s3->putObject($s3->inputFile($archive), $destination['bucket'], $destination['path'] . basename($archive));
    } catch (S3Exception $s3e) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/S3_UPLOAD_FAILED'), array($destination['name'], $s3e->getMessage()));
        sb_log_error(i18n_r(SB_SHORTNAME.'/S3_UPLOAD_FAILED'), array($destination['name'], $s3e->getMessage()));
        sb_log_error($s3e->message);
        return false;
    }

    return true;
}

function sb_compare_s3_object($a, $b) {
    $a = $a['time'];
    $b = $b['time'];
    return $a === $b ? 0 : ($a < $b ? -1 : 1);
}

function sb_clean_s3($destination, $match_pattern, $limit) {
    $s3 = sb_validate_s3($destination, false);
    if (!$s3) {
        return false;
    }

    try {
        $backups = array();
        $result = true;
        $bucket_contents = $s3->getBucket($destination['bucket'], $destination['path']);

        foreach ($bucket_contents as $key => $object) {
            if (strpos($key, $destination['path']) === 0) {
                $object['basename'] = str_replace($destination['path'], '', $key);
                if (preg_match($match_pattern, $object['basename'])) {
                    $backups[$key] = $object;
                }
            }
        }

        if (count($backups) > $limit) {
            uasort($backups, "sb_compare_s3_object");
            $filenames = array_keys($backups);
            $to_delete = count($backups) - $limit;
            for ($i = 0; $i < $to_delete; $i++) {
                try {
                    sb_log_debug("S3 delete - %s - %s", array($destination['name'], $filenames[$i]));
                    $s3->deleteObject($destination['bucket'], $filenames[$i]);
                } catch (S3Exception $s3e) {
                    $result = false;
                }
            }
        }
    } catch (S3Exception $s3e) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/S3_CLEAN_FAILED'), $destination['name']);
        sb_log_error(i18n_r(SB_SHORTNAME.'/S3_CLEAN_FAILED'), $destination['name']);
        sb_log_error($s3e->message);
        $result = false;
    }
    return $result;
}
