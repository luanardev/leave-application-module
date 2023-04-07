<?php

namespace Lumis\LeaveApplication\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class LeaveApprovedException extends HttpException
{

    public function __construct()
    {
        $message = 'Application Approved Already';
        parent::__construct(403, $message, null, []);
    }
}
