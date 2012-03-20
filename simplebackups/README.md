Simple Backups for GetSimple
============================
Automated, schedulable remote and local backups for your GetSimple websites -
because accidents happen.

Features
--------
* Gain peace of mind by automatically backing up your GetSimple websites
* **Schedule** your backups to run hourly, daily, weekly or monthly
* Send your backups via email, upload them to an FTP server, stash them in
  an Amazon S3 bucket, or just store them locally
* Backup as much or as little as you need - from just the page data for your
  site, to your entire GetSimple installation, to any arbitrary folder on
  your server

Installation
------------
1. Extract the zip file into your website's plugins/ directory
2. In your GetSimple admin panel, you should see a new tab: "Simple Backups"

Configuration
-------------
**Note**: This document is a work in progress - all feedback, suggestions,
corrections and complaints appreciated.

In Simple Backups, there are three things to configure: **Sources**,
**Destinations** and **Schedules**.

A **Source** defines a directory that contains things you want backed up.
Simple Backups comes with two sources pre-defined: "Data Files" points to your
GetSimple website's data/ directory, and will include any user- or
plugin-generated data from your site. "All Files" points to your GetSimple
website's root, and includes your entire website - the GetSimple code, the
plugins, the themes, the data, everything.

A **Destination** is somewhere backups can be stored when they're generated.
Simple Backups defines a "Local backups folder" destination by default, which
just points to the backups/simplebackups/ folder in your GetSimple website.
**Destinations** can be local folders, locations on FTP servers, Amazon S3
buckets, or email addresses.

A **Schedule** ties these together with information about how often you want it
to run (hourly, daily, etc.), and how many backups from that **Source** to the
**Destination** you want to keep. For example, you might create a **Schedule**
that uses the "All Files" **Source**, the "Local backups folder" destination,
runs daily, and keeps 14 backups - this would mean you'd always have daily
copies of your entire site for the last fortnight, stored right there on your
server.  Too simple.

**Sources**, **Destinations** and **Schedules** are all easily editable from
the "Simple Backups" tab in your website's admin panel.