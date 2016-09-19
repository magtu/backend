#!/usr/bin/env python
# -*- coding: utf-8 -*-

#0. convert dbf to sql dbfconv.com

#1. Read configs
import sys
sourceFileName = "ШАБЛОН.sql"
if len(sys.argv) > 1:
    sourceFileName = sys.argv[1]
targetFileName = "utf8_" + sourceFileName

import os.path
import ConfigParser

configFileName = './import_config.ini'

db_host = "localhost"
db_name = "schedule"
db_user = "mysql_user"
db_pass = "mysql_pass"
ini = ConfigParser.ConfigParser()
if len(ini.read(configFileName)) > 0:
    db_host = ini.get('dbConfig', 'db_host')
    db_name = ini.get('dbConfig', 'db_name')
    db_user = ini.get('dbConfig', 'db_user')
    db_pass = ini.get('dbConfig', 'db_pass')

print(sourceFileName)

import mysql.connector

mysql = mysql.connector.connect(user=db_user, password=db_pass,
                              host=db_host,
                              database=db_name)
mysql.close()

#2. Change file encoding
import codecs

with codecs.open(sourceFileName, "r", "cp866") as sourceFile:
    with codecs.open(targetFileName, "w", "utf-8") as targetFile:
        while True:
            contents = sourceFile.read(1024)
            if not contents:
                break
            targetFile.write(contents)

#3. 