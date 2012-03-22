Simple Backups for GetSimple
============================
Automated, schedulable, remote and local backups for your GetSimple websites -
because accidents happen.

[Download Simple Backups from GetSimple Extend](http://get-simple.info/extend/plugin/simple-backups/394/)

[Get the source for Simple Backups from GitHub](https://github.com/RWJMurphy/GetSimple-SimpleBackups)

Features
--------
* Gain peace of mind by automatically backing up your GetSimple websites
* Schedule your backups to run hourly, daily, weekly or monthly
* Send your backups via email, upload them to an FTP server, stash them in
  an Amazon S3 bucket, or just store them locally
* Backup as much or as little as you need - from just the page data for your
  site, to your entire GetSimple installation, to any arbitrary folder on
  your server

Requirements
------------
* GetSimple v3.1+
* PHP 5.x
* For .tar.gz archives:
    * access to PHP's `exec()` function
    * the `tar` and `gzip` commands installed on your server
* For .zip archives, one of:
    * PHP 5.2+ with --enable-zip
    * The [PECL zip extension](http://pecl.php.net/package/zip)
    * the `zip` command installed on your server, and `exec()` enabled in PHP
* For S3 storage
    * access to PHP's `curl*` functions

Installation
------------
1. Extract the zip file into your website's plugins/ directory
2. In your GetSimple admin panel, you should see a new tab: "Simple Backups"

Optionally:

3. Set up a hourly cron job to poll your website, so that backups are guaranteed to run:

`   15 * * * * curl -s http://your.getsimplewebsite.com/ > /dev/null`

Configuration
-------------
**Note**: This document is a work in progress - all feedback, suggestions,
corrections and complaints appreciated.

In Simple Backups, there are three things to configure: **Sources**,
**Destinations** and **Schedules**.

A **Source** defines a directory that contains things you want backed up.
Simple Backups comes with two sources pre-defined:
* "Data Files" points to your GetSimple website's `data/` directory and will
  include all user and plugin generated data from your site.
* "All Files" points to your GetSimple website's root and includes your entire
  website: the GetSimple code, the plugins, the themes, the data, everything.

A **Destination** is somewhere backups can be stored when they're generated.
Simple Backups defines a "Local Backups Folder" destination by default, which
points to the `backups/simplebackups/` folder in your GetSimple website.  A
**Destination** can be a local folder, a location on an FTP server, an Amazon
S3 bucket, or and email address. 

A **Schedule** ties together a **Source** and a **Destination**, along with
information about how often you want it to run (hourly, daily, etc.), and how
many backups from the **Source** to the **Destination** you want to keep. For
example, you might create a **Schedule** that uses the "All Files" **Source**,
the "Local Backups Folder" **Destination**, runs daily, and keeps 14 backups;
this would mean you'd always have daily copies of your entire site for the last
fortnight, stored right there on your server. Too simple.

**Sources**, **Destinations** and **Schedules** are all easily editable from
the "Simple Backups" tab in your website's admin panel.

Cron
----
Simple Backups makes uses of the `index-posttemplate` hook, so that it can
check for **Schedules** due to run whenever a page is loaded on your GetSimple
website. While this is fine for most sites, if you want more guarantee that
your backups will run *every* hour, it is recommended you set up a cron job to
poll your website. Any of the following examples would work:
    
    # Using curl, poll the website at 15 minutes past every hour
    15 * * * * curl -s http://your.getsimplewebsite.com/ > /dev/null
    
    # ... and the same, using wget
    15 * * * * wget -q http://your.getsimplewebsite.com/ -O /dev/null
