
###Assignment-7

~~~

###  Query  To get all the Earth Quakes that occurred in a single State 

~~~


SELECT e.SHAPE, e.location, s.state            
FROM earth_quakes e, state_borders s            
WHERE s.state =  'california'                
AND CONTAINS( s.shape, e.shape )  
ORDER BY e.location          


~~~
