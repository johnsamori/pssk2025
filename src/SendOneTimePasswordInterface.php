<?php

namespace PHPMaker2025\pssk2025;

/**
 * Send OTP interface
 */
interface SendOneTimePasswordInterface
{
    /**
     * Send one time password
     *
     * @param string $user User name
     * @param ?string $account User account, e.g. email, phone
     */
    public function sendOneTimePassword(string $user, #[\SensitiveParameter] ?string $account = null): bool|string;
}
