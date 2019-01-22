<?php

class EmailDNSValidate {

    public function onisValidEmailAddr( $addr, &$result )
    {
        // copied format validation from MediaWiki source (Sanitizer.php, function validateEmail)
        // even though this is redudant, since the hook scripts are called first, we still want
        // to make sure the format is valid before we try to parse it to get the domain
        $rfc5322_atext = "a-z0-9!#$%&'*+\\-\/=?^_`{|}~";
        $rfc1034_ldh_str = "a-z0-9\\-";
        $html5_email_regexp = "/
        ^                      # start of string
        [$rfc5322_atext\\.]+    # user part which is liberal
        @                      # 'apostrophe'
        [$rfc1034_ldh_str]+       # First domain part
        (\\.[$rfc1034_ldh_str]+)*  # Following part prefixed with a dot
        $                      # End of string
        /ix"; // case Insensitive, eXtended
        if (!preg_match( $html5_email_regexp, $addr ))
        {
            $result = "Email format validation failed";
            return false;
        }
        
        $domain = array_pop(explode("@", $addr));
        
        // check if the domain is actually an IP address, if so we assume it's valid
        
        // handle unicode domains, see https://php.net/manual/en/function.checkdnsrr.php#112739
        $domain = idn_to_ascii($domain);
        
        // domains should actually end in a . to prevent checkdnsrr from trying to lookup the domain
        // as a relative domain, see https://php.net/manual/en/function.checkdnsrr.php#119969
        if ($domain[-1] != ".")
        {
            $domain .= ".";
        }
        
        // check for the existance of the domain
        if (!checkdnsrr($domain, "ANY"))
        {
            $result = "Domain name not found in DNS";
            return false;
        }
        
        // all checks passed
        return true;
    }

}