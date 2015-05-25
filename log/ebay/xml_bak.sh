#!/bin/bash
tar -czf /mnt/html/it/log/ebay/ebay_xml_`date \-d "1 day ago" +\%Y_\%m_\%d`.tar.gz /mnt/html/it/log/ebay/xml/*.`date \-d "1 day ago" +\%Y\%m\%d`.*
rm /mnt/html/it/log/ebay/xml/*.`date \-d "1 day ago" +\%Y\%m\%d`.* -rf

