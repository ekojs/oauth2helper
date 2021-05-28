<?php declare(strict_types=1);
/**
 * Author: Eko Junaidi Salam <eko_junaidisalam@live.com>
 * License: AGPL-3.0-or-later
 * 
 * OAUTH2 Helper Library
 */

// @codeCoverageIgnoreStart
if (!function_exists('base64url_encode')) {
// @codeCoverageIgnoreEnd

    /**
     * Encode string to Base 64 Url Encode.
     *
     * @return string Base 64 Url Encode.
     */
    function base64url_encode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

}

// @codeCoverageIgnoreStart
if (!function_exists('base64url_decode')) {
// @codeCoverageIgnoreEnd

    /**
     * Decode Base 64 Url to string.
     *
     * @return string string.
     */
    function base64url_decode(string $data): string {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

}

// @codeCoverageIgnoreStart
if (!function_exists('state')) {
// @codeCoverageIgnoreEnd

    /**
     * Generate random state.
     *
     * @return string hex string.
     */
    function state(): string {
        return bin2hex(random_bytes(8));
    }

}

// @codeCoverageIgnoreStart
if (!function_exists('codeChallenge')) {
// @codeCoverageIgnoreEnd

    /**
     * Generate code_verifier and code_challenge for rfc7636 PKCE.
     * https://datatracker.ietf.org/doc/html/rfc7636#appendix-B
     *
     * @return array [code_verifier,code_challenge].
     */
    function codeChallenge(?string $code_verifier=null): ?array {
        $gen = function(){
            $strings = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~";
            $length = random_int(43,128);
            for ($i=0; $i < $length; $i++) { 
                yield $strings[random_int(0,65)];
            }
        };

        $code = $code_verifier ?? implode("",iterator_to_array($gen()));

        if(!preg_match('/[A-Za-z0-9-._~]{43,128}/',$code)){
            return null;
        }

        return [$code,base64url_encode(pack('H*', hash("sha256",$code)))];
    }

}