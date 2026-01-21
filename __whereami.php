<?php
@session_start();
header('Content-Type: text/plain; charset=utf-8');

echo "NOW: ".date('c')."\n";
echo "DOC_ROOT: ".($_SERVER['DOCUMENT_ROOT']??'NULL')."\n";
echo "SCRIPT_FILENAME: ".($_SERVER['SCRIPT_FILENAME']??'NULL')."\n";
echo "CWD: ".getcwd()."\n";

echo "ini error_log: ".(ini_get('error_log')?:'EMPTY')."\n";
echo "ini log_errors: ".(ini_get('log_errors')?:'')."\n";
echo "SAPI: ".php_sapi_name()."\n";

error_log("[PING] __whereami hit at ".date('c'));
echo "WROTE [PING] to error_log\n";
