<?php

namespace Inventory\Management\Domain\Model\Entity\RequestEmployee;

class RequestEmployeeStatus
{
    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_DRAFT_DELETED = 'DRAFT_DELETED';
    public const STATUS_SEND = 'SEND';
    public const STATUS_ACCEPTED = 'ACCEPTED';
    public const STATUS_DENIED = 'DENIED';
}
