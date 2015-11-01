SQL TABLE
==========


CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fabrication_year` year(4) NOT NULL,
  `producer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `fabrication_year`, `producer`) VALUES
(1, 1994, 'Mercedes'),
(2, 2000, 'BMW'),
(3, 1994, 'Audi'),
(4, 2005, 'BMW'),
(5, 2002, 'Audi'),
(6, 2014, 'BMW'),
(7, 1994, 'Mercedes'),
(8, 2000, 'BMW'),
(9, 2011, 'Audi'),
(10, 2000, 'BMW'),
(11, 2010, 'Audi'),
(12, 1989, 'BMW');


==========================
MYSQL SINGLE COMPLEX Query
==========================

NOTE: Please select all starting from next line till the end of file and then execute on above table

(SELECT y.* FROM
( 
SELECT 

CASE 
WHEN fabrication_year<=1998 THEN '0-1998' 
WHEN fabrication_year>=1999 AND fabrication_year<=2002 THEN '1999-2002'
WHEN fabrication_year>=2003 AND fabrication_year<=2006 THEN '2003-2006'
WHEN fabrication_year>=2007 AND fabrication_year<=2009 THEN '2007-2009'
WHEN fabrication_year>=2010 AND fabrication_year<=2016 THEN '2010-2016'
WHEN 1=1 THEN 'Total'
END as 'Fabrication_year',


IFNULL(
CASE 
WHEN fabrication_year<=1998 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year<=1998 AND producer='Audi') 
WHEN fabrication_year>=1999 AND fabrication_year<=2002 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=1999 AND fabrication_year<=2002 AND producer='Audi') 
WHEN fabrication_year>=2003 AND fabrication_year<=2006 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2003 AND fabrication_year<=2006 AND producer='Audi')
WHEN fabrication_year>=2007 AND fabrication_year<=2009 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2007 AND fabrication_year<=2009 AND producer='Audi')
WHEN fabrication_year>=2010 AND fabrication_year<=2016 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2010 AND fabrication_year<=2016 AND producer='Audi')


END,0) as 'Audi',

IFNULL(
CASE 
WHEN fabrication_year<=1998 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year<=1998 AND producer='BMW') 
WHEN fabrication_year>=1999 AND fabrication_year<=2002 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=1999 AND fabrication_year<=2002 AND producer='BMW') 
WHEN fabrication_year>=2003 AND fabrication_year<=2006 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2003 AND fabrication_year<=2006 AND producer='BMW')
WHEN fabrication_year>=2007 AND fabrication_year<=2009 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2007 AND fabrication_year<=2009 AND producer='BMW')
WHEN fabrication_year>=2010 AND fabrication_year<=2016 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2010 AND fabrication_year<=2016 AND producer='BMW')


END,0) as 'BMW',

IFNULL(
CASE 
WHEN fabrication_year<=1998 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year<=1998 AND producer='Mercedes') 
WHEN fabrication_year>=1999 AND fabrication_year<=2002 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=1999 AND fabrication_year<=2002 AND producer='Mercedes') 
WHEN fabrication_year>=2003 AND fabrication_year<=2006 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2003 AND fabrication_year<=2006 AND producer='Mercedes')
WHEN fabrication_year>=2007 AND fabrication_year<=2009 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2007 AND fabrication_year<=2009 AND producer='Mercedes')
WHEN fabrication_year>=2010 AND fabrication_year<=2016 THEN (SELECT count(*) FROM `cars` WHERE fabrication_year>=2010 AND fabrication_year<=2016 AND producer='Mercedes')


END,0) as 'Mercedes'

 FROM cars) y GROUP BY y.Fabrication_year) 

UNION 

(
SELECT 'Total' as 'Fabrication_year',
	(SELECT COUNT(*) FROM cars WHERE fabrication_year>0 and fabrication_year<=2016 and producer='Audi') as 'Audi',
	(SELECT COUNT(*) FROM cars WHERE fabrication_year>0 and fabrication_year<=2016 and producer='BMW') as 'BMW',
	(SELECT COUNT(*) FROM cars WHERE fabrication_year>0 and fabrication_year<=2016 and producer='Mercedes') as 'Mercedes'
)

