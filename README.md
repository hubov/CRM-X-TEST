# WORK ORDER IMPORTER

This module performs work orders imports. It parses HTML files and extracts required data.

## Requirements

The module requires Symfony DOM Scraper to parse HTML files.

## Usage:

### Web interface

Web interface of the importer module is accessible at `/importer`

### Console interface

Command to import a file via command line: `import:workorders {file}`
{file} is a file name/path to be parsed

### Reports

A CSV report is generated after a successful data import. A download is instantly triggered on web interface.
Reports are also accessible via web interface on the page `/importer` at any time. 

The report contains parsed data and a notice about status of each record - if a new work order record was created or skipped. 
Records are skipped if database contains a work order number already.