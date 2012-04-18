Version 1.0.5 (April 2012)
=========================
* Further __DIR__ purging

Version 1.0.4 (April 2012)
==========================
* The log store is now limited to 100 entries
* Added all used but undefined  i18n tokens
* Added a warning about gmail rejecting backup archives
* Minor bug fixes

Version 1.0.3 (April 2012)
==========================
* No longer using the __DIR__ magic variable - should now work with PHP < 5.3.0
* Minor bug fixes

Version 1.0.2 (March 2012)
==========================
* Fixed bug with non-XML entities in various fields
* Fixed lack of escaping HTML special characters in admin panels
* Added CDATA escaping and more robust XML loading
* Improved FTP validation

Version 1.0.1 (March 2012)
==========================
* Added ZipArchive support for creating .zip archives

Version 1.0.0 (March 2012)
==========================
Initial release.

* Source support: local directory
* Destination support: local directory, FTP server, email, S3
* Archive format support: .tar.gz, .zip
* Basic schedule implementation: hourly / daily / weekly / monthly
