#!/bin/bash

/usr/bin/mysqldump --user=root --password=123 --default-character-set=utf8 bikebook > ../data/last-dump.sql