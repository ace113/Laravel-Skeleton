<?php

/** GLOBAL CONSTANT STARTED**/
define('PER_PAGE_LIMIT',10);
/** GLOBAL CONSTANT ENDED**/
/*--2xx Success--*/
define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_NON_AUTHORITATIVE_INFORMATION', 203);
define('HTTP_NO_CONTENT', 204);
define('HTTP_API_ERROR', 212);

/*---------------4xx Client errors-------------------*/
define('HTTP_BAD_REQUEST', 400);
define('HTTP_UNAUTHORIZED', 401);
define('HTTP_PAYMENT_REQUIRED', 402);
define('HTTP_FORBIDDEN', 403);
define('HTTP_NOT_FOUND', 404);
define('EXPECTATION_FAILED',422);

/*-----------------------------5xx Server errors---------------------------- */
define('HTTP_INTERNAL_SERVER_ERROR', 500);
define('HTTP_NOT_IMPLEMENTED', 501);
define('HTTP_BAD_GATEWAY', 502);
define('HTTP_SERVICE_UNAVAILABLE', 503);

