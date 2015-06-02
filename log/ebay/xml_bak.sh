#!/bin/sh
tar -czf /mnt/html/it/log/ebay/ebay_xml_`date \-d "1 day ago" +\%Y_\%m_\%d`.tar.gz /mnt/html/it/log/ebay/xml/*.`date \-d "1 day ago" +\%Y\%m\%d`.*;
echo "compress and bak all xml file for "+`date \-d "1 day ago" +\%Y_\%m_\%d`;
rm /mnt/html/it/log/ebay/xml/*.`date \-d "1 day ago" +\%Y\%m\%d`.* -rf;
echo "delete all xml file for "+`date \-d "1 day ago" +\%Y_\%m_\%d`;
