<?php

namespace Lumis\LeaveApplication\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApprovalNotAllowedException extends HttpException
{

    public function __construct()
    {
        $message = 'Cannot Approve Request';
        parent::__construct(403, $message, null, []);
    }
}
