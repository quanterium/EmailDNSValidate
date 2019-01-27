# email-dns-validate
MediaWiki extension to validate the existence of the domain part of an email address.

## Installation

1. Clone the extension from GitHub to your wiki's extensions folder: `git clone https://github.com/quanterium/EmailDNSValidate.git`
2. Enable the extension by adding it to your LocalSettings.php file: `wfLoadExtension( 'EmailDNSValidate' );`

## Configuration

At this time, there are no configuration options for this extension.

## What it Does

MediaWiki by default validates only the format of an email address. This extension extends
that validation to also verify the existence of the domain component. The domain name must
be registered in DNS; an MX record is not required since a site does not require one if the
IP address associated with the domain runs the SMTP server.

IP addresses in place of the domain are allowed; this extension will check for and block IP
addresses in private or reserved address blocks.

## Bugs Reports and Feature Requests

Bugs Reports and Feature Requests can be made by creating an Issue on GitHub. Pull requests for
changes are also welcome.
