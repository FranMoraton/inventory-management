<?php

namespace Inventory\Management\Domain\Model\HttpResponses;

class HttpResponses
{
    const BAD_REQUEST = 400;
    const NOT_FOUND = 404;
    const UNAUTHORIZED = 401;
    const CONFLICT_SEARCH = 409;
    const OK = 200;
    const OK_CREATED = 201;
    const KO = 500;
}
