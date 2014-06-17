SHP file  :   

The shapefile is in fact a grouping of several files formatted to represent different aspects of geodata:
.shp — shape format; the feature geometry itself.
.shx — shape index format; a positional index of the feature geometry to allow seeking forwards and backwards quickly.
.dbf — attribute format; columnar attributes for each shape, in dBase IV format.


OSM File   : 

OpenStreetMap data files are traditionally distributed in an XML format representing the node, way, and relation concepts using a simple schema. Without compression, this XML format can be extremely large, so it is usually distributed using an efficient compression algorithm like gzip or bz2. Most of the tools designed to work with the OSM XML data format can also handle the compressed XML.

GeoJSON FIle : 


GeoJSON is a format for encoding a variety of geographic data structures. 
A GeoJSON object may represent a geometry, a feature, or a collection of features. 
GeoJSON supports the following geometry types: Point, LineString, Polygon, MultiPoint, MultiLineString, MultiPolygon,
 and GeometryCollection. Features in GeoJSON contain a geometry object and additional properties, and a feature collection
 represents a list of features.


GPX       : 

GPX (the GPS Exchange Format) is a light-weight XML data format for the interchange of GPS data (waypoints, routes, and tracks) between applications and Web services on the Internet.

OGR has support for GPX reading (if GDAL is build with expat library support) and writing.


KML      : 


Keyhole Markup Language (KML) is an XML-based markup language designed to annotate and overlay visualizations 
on various two-dimensional, Web-based online maps or three-dimensional Earth browsers (such as Google Earth).
 In fact, KML was initially developed for use with Google Earth; 


 NMEA    : 
 
 Your GPS receiver might output or record your tracks in NMEA format, this is a format that can easily be converted to GPX
 so you can upload it to our website. Even though GPX is preferred there are still several OpenStreetMap tools that support NMEA including new versions of JOSM.
 
 
 CSV      :  
  
 A CSV file is commonly described as a ‘Comma Delimited File’ or a ‘Character Separated File’.
 The second description is more accurate since any character including the comma, can be used to delineate each piece of data. 
 For example, a TSV file, ‘commonly known as a ‘Tab Delimited File’, is really just a special case of a CSV file.
 Since a CSV file is a simple text file (ASCII or Unicode) it can be easily opened by Notepad.exe which is included in all
 versions of MS Windows.
 
 
QGIS      :   


QGIS understands three major forms of data. Two of these are spatial (ie, they contain information allows it to be shown in space) and the third contains no spatial data (" aspatial data").
In QGIS, Add VECTOR DATA and under BROWSE, set files of type to "Keyhole Markup Language (KML)"



GPS BABEL  : 

This format can 

read and write tracks

read and write routes

This format has the following options: timeadj .

FAI/IGC Data File -- Used by the international gliding community to record gliding flights. IGC files can be converted to and from tracks representing recorded flights, and routes representing task declarations in other formats.


